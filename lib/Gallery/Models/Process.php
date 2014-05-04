<?php

namespace Gallery\Models;

use Comments\Models\Db\Table\Comments;
use Core\View\Ajax\View;
use Core\View\Message;
use Core\Models\Generator\Url;
use Gallery\Models\Db\Table\Gallery_Albums;
use Gallery\Models\Db\Table\Gallery_Images;

class Process {

    public function __construct($action) {
        if (method_exists($this, $action))
            call_user_func([$this, $action]);
    }

    private function overview() {
        $table = new Gallery_Albums();
        $albums = $table->loadAlbums($_POST['userid']);
        if ($albums !== NULL) {
            $view = new View(true);
            $view->addData(["result" => $albums]);
            $view->sendResponse();
        } else
            new Message("Sorry", "We can't find any albums!", "danger");
    }

    private function create() {
        $table = new Gallery_Albums();
        $result = $table->insert([
            "title" => $_POST['title'],
            "description" => $_POST['description'],
            "userid" => $_SESSION['user']->userid,
            "type" => ($_POST['privacy'] == 0) ? "shared" : NULL,
            "user_upload" => isset($_POST['allow_upload']) ? 1 : 0,
            "privacy" => $_POST['privacy']
        ]);
        $view = new View($result !== NULL);
        $view->addData(["target" => Url::convertUrl("index.php?m=gallery&action=" . $result . "&x=" . str_replace(" ", "_", $_POST['title']))]);
        $view->sendResponse();
    }

    private function edit() {
        $table = new Gallery_Albums();
        $album = $table->find($_POST['albumid'])->current();
        $result = $album->update($_POST);
        $view = new View();
        $view->setStatus($result !== NULL);
        $view->sendResponse();
    }

    private function upload() {
        $albums = new Gallery_Albums();
        $images = new Gallery_Images();
        if (isset($_POST['newsfeed_post'])) {
            $album = $albums->fetchRow($albums->select()->where("type=?", "newsfeed")->where("userid=?", $_SESSION['user']->userid));
            if ($album === NULL) {
                $albumid = $albums->newNewsfeedAlbums($_SESSION['user']->userid);
                $album = $albums->fetchRow($albums->select()->where("id=?", $albumid));
            }
        } else
            $album = $albums->find($_POST['albumid'])->current();
        $result = $images->uploadImage($album->id, isset($_POST['newsfeed_post']));
        $album->addImage((isset($_POST['newsfeed_post'])) ? $result['content'] : $result['imageid']);
        $view = new View($result !== false);
        $view->addData($result);
        $view->sendResponse();
    }

    private function deleteImage() {
        $images = new Gallery_Images();
        $image = $images->find($_POST['imageid'])->current();
        $view = new View();
        $view->setStatus(($image !== NULL) ? $image->deleteImage() : false);
        $view->sendResponse();
    }

    private function loadImage() {
        $id = $_POST['id'];
        $images = new Gallery_Images();
        $result = $images->getImageData($id);
        $view = new View(true);
        if ($result !== NULL) {
            $result = $result[0];
            $likeTable = new \Likes\Models\Db\Table\Likes();
            $socialData['likes'] = $likeTable->getLikes($id, "image");
            $socialData['dislikes'] = $likeTable->getLikes($id, "image", 1);

            if ($result['commentcount'] > 0) {
                $comments = new Comments();
                $socialData['comments'] = $comments->get($id, "image", false, 13);
            } else
                $socialData['comments'] = [];
            $view->addData(array_merge($socialData, $result));
        } else
            $view->setStatus(false);
        $view->sendResponse();
    }

    private function loadImages() {
        $images = new Gallery_Images();
        $result = $images->getImages($_POST['albumid'], ["limit" => $_POST['limit'], "offset" => $_POST['offset']]);
        $view = new View($result !== false);
        $view->addData(["result" => $result]);
        $view->sendResponse();
    }

    private function loadAlbum() {
        $albums = new Gallery_Albums();
        $album = $albums->getAlbumData($_GET['action']);
        if ($album->current() instanceof \Zend_Db_Table_Row_Abstract) {
            $view = new \Gallery\View\Album();
            $album = $album->current()->toArray();
            if ($album['type'] == 'profile')
                $album['title'] = $view->translate("Profile Images");
            else if ($album['type'] == "newsfeed")
                $album['title'] = $view->translate("Posted Images");
            $view->setMetaData(["title" => $album['title'], "description" => $album['description']]);
            $view->assign("album", $album);
            if ($album->userid == $_SESSION['userid'])
                $view->registerScript("gallery", "album-edit");
            $view->show();
        } else
            new \Core\View\PageNotFound();
    }

    function deleteAlbum() {
        $albums = new Gallery_Albums();
        $album = $albums->find($_POST['albumid'])->current();
        $view = new View($album->deleteAlbum());
        $view->sendResponse();
    }

}
