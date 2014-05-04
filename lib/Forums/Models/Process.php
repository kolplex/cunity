<?php

namespace Forums\Models;

use Core\View\Ajax\View;
use \Forums\Models\Db\Table\Forums;
use \Forums\Models\Db\Table\Boards;
use \Forums\Models\Db\Table\Threads;
use \Forums\Models\Db\Table\Posts;
use \Forums\Models\Db\Table\Categories;

class Process {

    public function __construct($action) {
        if (method_exists($this, $action))
            call_user_func([$this, $action]);
    }

    private function loadForums() {
        $forums = new Forums;
        $topics = new Boards;
        $res = $forums->loadForums();
        if ($res !== NULL && $res !== false)
            for ($i = 0; $i < count($res); $i++)
                $res[$i]["boards"] = $topics->loadBoards($res[$i]["id"]);
        $view = new View($res !== NULL && $res !== false);
        $view->addData(["result" => $res]);
        $view->sendResponse();
    }

    private function loadBoards() {
        $boards = new Boards;
        $res = $boards->loadBoards($_POST['id']);
        $view = new View($res !== NULL && $res !== false);
        $view->addData(["result" => $res]);
        $view->sendResponse();
    }

    private function loadPosts() {
        $posts = new Posts;
        $res = $posts->loadPosts($_POST['id'], 20, ($_POST['page'] - 1) * 20);
        $view = new View($res !== NULL && $res !== false);
        if ($res !== false) {
            foreach ($res AS $i => $r) {
                $res[$i]['content'] = $this->quote(htmlspecialchars_decode($r['content']));
            }
            $view->addData(["result" => $res]);
        }
        $view->sendResponse();
    }

    private function forum() {
        $boards = new Forums;
        $data = $boards->loadForumData($_GET['x']);
        if ($data == false)
            new \Core\View\PageNotFound;
        $view = new \Forums\View\Forum();
        $view->setMetaData(["title" => $data['title']]);
        $view->assign("forum", $data);
        $view->show();
    }

    private function board() {
        $boards = new Boards;
        $cat = new Categories;
        $data = $boards->loadBoardData($_GET['x']);
        if ($data == false)
            new \Core\View\PageNotFound;
        $view = new \Forums\View\Board();
        $view->setMetaData(["title" => $data['title']]);

        $view->assign("categories", $cat->getCategories());
        $view->assign("board", $data);
        $view->show();
    }

    private function thread() {
        $threads = new Threads;
        $cat = new Categories;
        $data = $threads->loadThreadData($_GET['x']);
        if ($data == false)
            new \Core\View\PageNotFound;
        $view = new \Forums\View\Thread();
        $view->setMetaData(["title" => $data['title']]);
        $view->assign("thread", $data);
        $view->assign("categories", $cat->getCategories());
        $view->show();
    }

    private function category() {
        if (!isset($_GET['x']) || empty($_GET['x']))
            new \Core\View\PageNotFound;
        $cat = new Categories;
        $data = $cat->getCategoryData($_GET['x']);
        if ($data == false)
            new \Core\View\PageNotFound;
        $view = new \Forums\View\Category();
        $view->setMetaData(["title" => $view->translate("Category") . ": " . $data['name']]);
        $view->assign("category", $data);
        $view->show();
    }

    private function loadThreads() {
        $threads = new Threads;
        if (isset($_POST['id']))
            $res = $threads->loadThreads($_POST['id']);
        else if (isset($_POST['cat']))
            $res = $threads->loadCategoryThreads($_POST['cat']);
        $view = new View($res !== NULL && $res !== false);
        if ($res !== false) {
            foreach ($res AS $i => $r)
                $res[$i]['content'] = strip_tags(htmlspecialchars_decode($r['content']));
            $view->addData(["result" => $res]);
        }
        $view->sendResponse();
    }

    private function createForum() {
        $forums = new Forums;
        $res = $forums->add(["title" => $_POST['title'], "description" => $_POST['description'], "board_permissions" => (isset($_POST['board_permissions'])) ? $_POST['board_permissions'] : 0]);
        $view = new View($res !== false);
        if ($res !== false)
            $view->addData(["forum" => $res]);
        $view->sendResponse();
    }

    private function createBoard() {
        $forums = new Boards;
        $res = $forums->add(["title" => $_POST['title'], "description" => $_POST['description'], "forum_id" => $_POST['forum_id']]);
        $view = new View($res !== false);
        if ($res !== false)
            $view->addData(["board" => $res]);
        $view->sendResponse();
    }

    private function startThread() {
        $threads = new Threads;
        $posts = new Posts;
        $res = $threads->insert([
            "title" => $_POST['title'],
            "board_id" => $_POST['board_id'],
            "userid" => $_SESSION['user']->userid,
            "category" => $_POST['category'],
            "important" => (isset($_POST['important']) && $_SESSION['user']->isAdmin()) ? $_POST['important'] : 0
        ]);
        $view = new View(false);
        if ($res !== false) {
            $postRes = $posts->post(["content" => $_POST['content'], "thread_id" => $res, "userid" => $_SESSION['user']->userid]);
            $view->setStatus($postRes !== false);
            $view->addData(["id" => $res]);
        }
        $view->sendResponse();
    }

    private function postReply() {
        $posts = new Posts;
        $res = $posts->post($_POST);
        $view = new View(false);
        if ($res !== false) {
            $view->setStatus(true);
            $res['content'] = $this->quote(htmlspecialchars_decode($res['content']));
            $view->addData(["post" => $res]);
        }
        $view->sendResponse();
    }

    private function quote($str) {
        $format_search = [];
        $format_replace = [];
        if (preg_match_all('#\[quote=(.*?)\](.*?)#is', $str, $matches1, PREG_SET_ORDER) == preg_match_all('#\[/quote\]#is', $str, $matches2)) {
            if (empty($matches1))
                return $str;
            array_push($format_search, '#\[quote=(.*?)\](.*?)#is');
            array_push($format_search, '#\[/quote\]#is');
            $user = $_SESSION['user']->getTable()->get($matches1[0][1], "username");
            array_push($format_replace, '<div class="quotation well well-sm"><a class="quotation-user" href="' . \Core\Models\Generator\Url::convertUrl("index.php?m=profile&action=" . $user->username) . '">' . $user->name . ':</a>$2');
            array_push($format_replace, '</div>');
        }

        return preg_replace($format_search, $format_replace, $str);
    }

    private function loadCategories() {
        $cat = new Categories();
        $res = $cat->getCategories();
        $view = new View($res !== false);
        if ($res !== false)
            $view->addData(["result" => $res]);
        $view->sendResponse();
    }

    private function editForum() {
        $forums = new Forums;
        $res = $forums->update(["title" => $_POST['title'], "description" => $_POST['description'], "board_permissions" => (isset($_POST['board_permissions'])) ? $_POST['board_permissions'] : 0], $forums->getAdapter()->quoteInto("id=?", $_POST['forum_id']));
        $view = new View($res !== false && $res > 0);
        $view->sendResponse();
    }

    private function editBoard() {
        $boards = new Boards;
        $res = $boards->update(["title" => $_POST['title'], "description" => $_POST['description']], $boards->getAdapter()->quoteInto("id=?", $_POST['board_id']));
        $view = new View($res !== false && $res > 0);
        $view->sendResponse();
    }

    private function deletePost() {
        $posts = new Posts;
        $data = $posts->getPost($_POST['id']);
        $view = new View(false);
        if ($_SESSION['user']->isAdmin() || $data['userid'] == $_SESSION['user']->userid)
            $view->setStatus($posts->deletePost($_POST['id']));
        $view->sendResponse();
    }

    private function editThread() {
        $threads = new Threads;
        $res = $threads->update([
            "title" => $_POST['title'],
            "category" => $_POST['category'],
            "important" => (isset($_POST['important']) && $_SESSION['user']->isAdmin()) ? $_POST['important'] : 0
                ], $threads->getAdapter()->quoteInto("id=?", $_POST['thread_id']));
        $view = new View($res !== false);
        $view->sendResponse();
    }

    function deleteForum() {
        $forums = new Forums;
        $view = new View(false);
        if ($_SESSION['user']->isAdmin())
            $view->setStatus($forums->deleteForum($_POST['id']));
        $view->sendResponse();
    }

    function deleteBoard() {
        $boards = new Boards;
        $view = new View(false);
        if ($_SESSION['user']->isAdmin())
            $view->setStatus($boards->deleteBoard($_POST['id']));
        $view->sendResponse();
    }

    function deleteThread() {
        $threads = new Threads;
        $view = new View(false);
        if ($_SESSION['user']->isAdmin())
            $view->setStatus($threads->deleteThread($_POST['id']));
        $view->sendResponse();
    }

}
