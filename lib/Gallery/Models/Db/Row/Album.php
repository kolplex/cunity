<?php

namespace Gallery\Models\Db\Row;

use Gallery\Models\Db\Table\Gallery_Images;

class Album extends \Zend_Db_Table_Row_Abstract {

    public function deleteAlbum() {
        $images = new Gallery_Images();
        $imageslist = $images->getImages($this->id);
        $settings = \Core\Cunity::get("settings");
        foreach ($imageslist AS $image) {
            $likes = new \Likes\Models\Db\Table\Likes();
            $comments = new \Comments\Models\Db\Table\Comments();

            $comments->delete($this->getTable()->getAdapter()->quoteInto("ref_id=? AND ref_name='image'", $image['id']));
            $likes->delete($this->getTable()->getAdapter()->quoteInto("ref_id=? AND ref_name='image'", $image['id']));
            unlink("../data/uploads/" . $settings->getSetting("filesdir") . "/" . $image['filename']);
            unlink("../data/uploads/" . $settings->getSetting("filesdir") . "/thumb_" . $image['filename']);
            if (file_exists("../data/uploads/" . $settings->getSetting("filesdir") . "/cr_" . $image['filename']))
                unlink("../data/uploads/" . $settings->getSetting("filesdir") . "/cr_" . $image['filename']);
        }
        $images->delete($images->getAdapter()->quoteInto("albumid=?", $this->id));
        return (0 < $this->delete());
    }

    public function update(array $updates) {
        foreach ($updates AS $field => $value)
            if (isset($this->_data[$field]))
                $this->__set($field, $value);
        return $this->save();
    }

    public function getImages() {
        $images = new Gallery_Images();
        return $images->getImages($this->id);
    }

    public function addImage($imageid) {
        $this->photo_count++;
        $this->time = new \Zend_Db_Expr("UTC_TIMESTAMP()");
        $this->cover = $imageid;
        return $this->save();
    }

    private function getLastImageId() {
        $images = new Gallery_Images();
        $res = $images->fetchRow($images->select()->where("albumid=?", $this->id)->order("time")->limit(1));
        if ($res === NULL)
            return 0;
        else
            return $res->id;
    }

    public function removeImage($imageid) {
        if ($this->cover == $imageid)
            $this->cover = $this->getLastImageId();;
        $this->photo_count--;
        return $this->save();
    }

}
