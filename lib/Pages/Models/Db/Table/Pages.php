<?php

namespace Pages\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Pages extends Table {

    protected $_name = 'pages';
    protected $_primary = 'shortlink';
    protected $_rowClass = "\Pages\Models\Db\Row\Page";

    public function __construct() {
        parent::__construct();
    }

    public function getPage($shortlink) {
        return $this->fetchRow($this->select()->where("shortlink=?", $shortlink));
    }

    public function getPageById($id) {
        return $this->fetchRow($this->select()->where("id=?", intval($id)));
    }

    public function addPage(array $data) {
        if (isset($data['pageid']) && $data['pageid'] > 0) {
            if (false !== $this->update([
                        "title" => $data['title'],
                        "content" => $data['content'],
                        "comments" => isset($data['comments']) ? 1 : 0,
                        "shortlink" => preg_replace('/[^a-zA-Z0-9\-]/', "", $data['title'])
                            ], "id=" . $data['pageid']))
                return $data['pageid'];
        } else {
            return $this->insert([
                        "title" => $data['title'],
                        "content" => $data['content'],
                        "comments" => isset($data['comments']) ? 1 : 0,
                        "shortlink" => preg_replace('/[^a-zA-Z0-9\-]/', "", $data['title'])
            ]);
        }
    }

    public function deletePage($pageid) {
        return ($this->delete($this->getAdapter()->quoteInto("id=?", $pageid)) > 0);
    }

    public function loadPages() {
        $res = $this->fetchAll();
        foreach ($res AS $page)
            $page->content = html_entity_decode($page->content);

        return $res;
    }

}
