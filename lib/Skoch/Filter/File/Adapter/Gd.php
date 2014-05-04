<?php

/**
 * Zend Framework addition by skoch
 * 
 * @category   Skoch
 * @package    Skoch_Filter
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author     Stefan Koch <cct@stefan-koch.name>
 */

/**
 * Resizes a given file with the gd adapter and saves the created file
 *
 * @category   Skoch
 * @package    Skoch_Filter
 */
class Skoch_Filter_File_Adapter_Gd extends
\Skoch_Filter_File_Adapter_Abstract {

    public function resize($width, $height, $keepRatio, $file, $target, $keepSmaller = true) {
        list($oldWidth, $oldHeight, $type) = getimagesize($file);

        switch ($type) {
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($file);
                break;
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($file);
                break;
        }

        if (!$keepSmaller || $oldWidth > $width || $oldHeight > $height) {
            if ($keepRatio) {
                list($width, $height) = $this->_calculateWidth($oldWidth, $oldHeight, $width, $height);
            }
        } else {
            $width = $oldWidth;
            $height = $oldHeight;
        }

        $thumb = imagecreatetruecolor($width, $height);

        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);

        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);

        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);
        imagejpeg($thumb, $target);

        return $target;
    }

    public function thumbnail($file, $target, $thumbwidth) {
        list($width, $height, $type) = getimagesize($file);

        switch ($type) {
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($file);
                break;
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($file);
                break;
        }
        $x = $width / 4;
        $y = $height / 4;
        $w = $width / 2;
        $h = $w;
        $thumb = imagecreatetruecolor($thumbwidth, $thumbwidth);

        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);

        imagecopyresampled($thumb, $source, 0, 0, $x, $y, $thumbwidth, $thumbwidth, $w, $h);

        imagejpeg($thumb, $target);

        return $file;
    }

    public function crop($x, $y, $x1, $y1, $file, $target, $thumbwidth) {
        list($width, $height, $type) = getimagesize($file);

        switch ($type) {
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($file);
                break;
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($file);
                break;
        }

        $w = abs($x1 - $x);
        $h = abs($y1 - $y);
        $destinationRatio = $w / $h;
        $thumb = imagecreatetruecolor($thumbwidth, $thumbwidth / $destinationRatio);

        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);

        imagecopyresampled($thumb, $source, 0, 0, $x, $y, $thumbwidth, $thumbwidth / $destinationRatio, $w, $h);

        imagejpeg($thumb, $target);

        return $file;
    }

}
