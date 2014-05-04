<?php

namespace Pages\Models\Db\Row;

class Page extends \Zend_Db_Table_Row_Abstract {

    public function displayPage() {
        if (isset($_GET['x']) && $_GET['x'] == "textonly") {
            echo $this->content;
        } else {
            $this->content = html_entity_decode($this->content);
            $view = new \Pages\View\Page();
            $view->setMetaData(["title" => $this->title]);
            $view->assign("page", $this->_data);
            $view->show();
        }
    }

}
