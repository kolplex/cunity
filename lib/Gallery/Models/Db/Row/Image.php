<?php

namespace Gallery\Models\Db\Row;

use Gallery\Models\Db\Table\Gallery_Albums;

class Image extends \Zend_Db_Table_Row_Abstract {

    public function deleteImage() {
        if ($this->userid == $_SESSION['user']->userid) {
            $albums = new Gallery_Albums();
            $album = $albums->find($this->albumid);
            $album->current()->removeImage($this->id);
            $settings = \Core\Cunity::get("settings");
            $likes = new \Likes\Models\Db\Table\Likes();
            $comments = new \Comments\Models\Db\Table\Comments();

            $comments->delete($this->_getTable()->getAdapter()->quoteInto("ref_id=? AND ref_name='image'", $this->id));
            $likes->delete($this->_getTable()->getAdapter()->quoteInto("ref_id=? AND ref_name='image'", $this->id));
            unlink("../data/uploads/" . $settings->getSetting("filesdir") . "/" . $this->filename);
            unlink("../data/uploads/" . $settings->getSetting("filesdir") . "/thumb_" . $this->filename);
            if (file_exists("../data/uploads/" . $settings->getSetting("filesdir") . "/cr_" . $this->filename))
                unlink("../data/uploads/" . $settings->getSetting("filesdir") . "/cr_" . $this->filename);
            return ($this->delete() == 1);
        }
        return false;
    }

}
