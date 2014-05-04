<?php

namespace Gallery\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;
use Gallery\Models\Uploader;

class Gallery_Images extends Table {

    protected $_name = 'gallery_images';
    protected $_primary = 'id';
    protected $_rowClass = "\Gallery\Models\Db\Row\Image";

    public function __construct() {
        parent::__construct();
    }

    public function getImages($albumid, array $limit = []) {
        $query = $this->getAdapter()->select()->from(["i" => $this->dbprefix . "gallery_images"])
                ->joinLeft(["co" => $this->dbprefix . "comments"], "co.ref_id = i.id AND co.ref_name = 'image'", "COUNT(DISTINCT co.id) AS comments")
                ->joinLeft(["li" => $this->dbprefix . "likes"], "li.ref_id = i.id AND li.ref_name = 'image' AND li.dislike = 0", "COUNT(DISTINCT li.id) AS likes")
                ->joinLeft(["di" => $this->dbprefix . "likes"], "di.ref_id = i.id AND di.ref_name = 'image' AND di.dislike = 1", "COUNT(DISTINCT di.id) AS dislikes")
                ->joinLeft(["ld" => $this->dbprefix . "likes"], "ld.ref_id = i.id AND ld.ref_name = 'image' AND ld.userid = " . $this->getAdapter()->quote($_SESSION['user']->userid), "ld.dislike AS ownlike")
                ->where("i.albumid=?", $albumid)
                ->group("i.id");
        if (!empty($limit)) {
            $query->limit($limit['limit'], $limit['offset']);
        }
        $result = $this->getAdapter()->fetchAll($query);
        return $result;
    }

    public function getImageData($imageid) {
        return $this->getAdapter()->fetchAll(
                        $this->getAdapter()->select()->from(["i" => $this->dbprefix . "gallery_images"])
                                ->joinLeft(["u" => $this->dbprefix . "users"], "u.userid=i.userid", ["username", "name"])
                                ->joinLeft(["ci" => $this->dbprefix . "gallery_images"], "ci.id=u.profileImage", ["profileImage" => "filename"])
                                ->joinLeft(["co" => $this->dbprefix . "comments"], "co.ref_id = i.id AND co.ref_name = 'image'", "COUNT(DISTINCT co.id) AS commentcount")
                                ->joinLeft(["li" => $this->dbprefix . "likes"], "li.ref_id = i.id AND li.ref_name = 'image' AND li.dislike = 0", "COUNT(DISTINCT li.id) AS likescount")
                                ->joinLeft(["di" => $this->dbprefix . "likes"], "di.ref_id = i.id AND di.ref_name = 'image' AND di.dislike = 1", "COUNT(DISTINCT di.id) AS dislikescount")
                                ->joinLeft(["ld" => $this->dbprefix . "likes"], "ld.ref_id = i.id AND ld.ref_name = 'image' AND ld.userid = " . $this->getAdapter()->quote($_SESSION['user']->userid), "ld.dislike AS ownlike")
                                ->where("i.id=?", $imageid)
                                ->group("i.id"));
    }

    public function uploadImage($albumid, $newsfeed_post = false) {
        if (isset($_FILES) && isset($_FILES['file']) && $albumid > 0) {
            $uploader = new Uploader();            
            $file = $uploader->upload($albumid . sha1($_SESSION['user']->userhash . time()) . rand());
            $imageid = $this->insert(["userid" => $_SESSION['user']->userid, "albumid" => $albumid, "filename" => $file,"caption" => (!empty($_POST['content']))?$_POST['content']:""]);
            if ($newsfeed_post) {
                $posts = new \Newsfeed\Models\Db\Table\Posts();
                return $posts->post([
                            "wall_owner_id" => $_POST['wall_owner_id'],
                            "wall_owner_type" => $_POST['wall_owner_type'],
                            "wall_id" => $_POST['wall_id'],
                            "privacy" => $_POST['privacy'],
                            "userid" => $_SESSION['user']->userid,
                            "content" => $imageid,
                            "type" => "image"
                ]);
            }
            return ["filename" => $file, "imageid" => $imageid];
        }
        return false;
    }

    public function uploadProfileImage() {
        $albums = new Gallery_Albums();
        $res = $albums->fetchRow($albums->select()->where("type=?", "profile")->where("userid=?", $_SESSION['user']->userid));
        if ($res === NULL) {
            $albumid = $albums->newProfileAlbums($_SESSION['user']->userid);
            $res = $albums->fetchRow($albums->select()->where("type=?", "profile")->where("userid=?", $_SESSION['user']->userid));
        } else
            $albumid = $res->id;
        $result = $this->uploadImage($albumid);
        $res->addImage($result['imageid']);
        if (is_array($result))
            return $result;
        return false;
    }

}
