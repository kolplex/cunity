<?php

namespace Search\Models;

class Process {

    private $indexfile = "../data/searchindex";

    public function find($queryString) {
        $queryString = trim($queryString);
        if (empty($queryString))
            return ["queryString" => $queryString, "message" => "No String"];
        else {
            $index = \Zend_Search_Lucene::open($this->indexfile);
            $res = explode(' ', $queryString);
            \Zend_Search_Lucene_Search_Query_Wildcard::setMinPrefixLength(1);
            \Zend_Search_Lucene::setResultSetLimit(5);
            $query = new \Zend_Search_Lucene_Search_Query_Boolean();
            foreach ($res as $val) {
                if (!empty($val)) {
                    $subquery = new \Zend_Search_Lucene_Search_Query_Boolean();
                    $searchkey1 = $val . "*";
                    $pattern = new \Zend_Search_Lucene_Index_Term($searchkey1, "name");
                    $userQuery = new \Zend_Search_Lucene_Search_Query_Wildcard($pattern);
                    $patternUsername = new \Zend_Search_Lucene_Index_Term($searchkey1, "username");
                    $usernameQuery = new \Zend_Search_Lucene_Search_Query_Wildcard($patternUsername);
                    $subquery->addSubquery($userQuery, null);
                    $subquery->addSubquery($usernameQuery, null);
                    $query->addSubquery($subquery, true);
                }
            }
            $hits = $index->find($query);
            if (!empty($hits)) {
                $results = [];
                foreach ($hits as $hit)
                    if ($hit->username !== $_SESSION['user']->username)
                        $results[] = $hit->username;
                if (!empty($results)) {
                    $users = $_SESSION['user']->getTable();
                    if (isset($_POST['friends'])) {
                        $friends = $_SESSION['user']->getFriendList();
                        if (empty($friends))
                            return ["queryString" => $queryString, "users" => []];
                        else
                            $userresult = $users->getSetIn($results,$friends, "username", "userid", ["userid", "username", "name"]);
                    } else
                        $userresult = $users->getSet($results, "u.username", ["u.userid", "u.username", "u.name"]);
                    return ["queryString" => $queryString, "users" => $userresult->toArray()];
                }
            }
        }
        return ["queryString" => $queryString];
    }

    public function addUser($username, $name) {
        try {
            $index = \Zend_Search_Lucene::open($this->indexfile);
        } catch (\Zend_Search_Lucene_Exception $e) {
            $index = \Zend_Search_Lucene::create($this->indexfile);
        }

        $doc = new \Zend_Search_Lucene_Document();
        $doc->addField(\Zend_Search_Lucene_Field::Text('username', $username));
        $doc->addField(\Zend_Search_Lucene_Field::unStored('name', $name));
        $index->addDocument($doc);
        $index->optimize();
        return true;
    }

    public function updateUser($username, $newusername, $newname) {
        $index = \Zend_Search_Lucene::open($this->indexfile);
        $hits = $index->find('username:' . $username);

        foreach ($hits as $hit)
            $index->delete($hit->id);
        return $this->addUser($newusername, $newname);
    }

    public function removeUser($username) {
        $index = \Zend_Search_Lucene::open($this->indexfile);
        $hits = $index->find('username:' . $username);
        foreach ($hits as $hit) {
            $index->delete($hit->id);
        }
    }

}
