<?php

namespace Admin\Models;

use \Core\Cunity;

class Process {

    private $validForms = ["config", "settings", "mailtemplates"];

    public function __construct($form) {
        if (in_array($form, $this->validForms))
            $this->save($form);
    }

    private function save($form) {
        $res = [];
        switch ($form) {
            case "settings":
                foreach ($_POST AS $key => $value) {
                    if (strpos($key, "settings-") !== false) {
                        $setting = explode("-", $key);
                        $settings = \Core\Cunity::get("settings");
                        $res[] = $settings->setSetting($setting[1], $value);
                    }
                }
                break;
            case "config":
                $config = new \Zend_Config_Xml("../data/config.xml");
                $configWriter = new \Zend_Config_Writer_Xml(["config" => new \Zend_Config(self::array_merge_recursive_distinct($config->toArray(), $_POST['config'])), "filename" => "../data/config.xml"]);
                $configWriter->write();
                break;
            case "mailtemplates":
                $settings = Cunity::get("settings");
                $res[] = $settings->mail_header = $_POST['mail_header'];
                $res[] = $settings->mail_footer = $_POST['mail_footer'];

                break;
        }
        $view = new \Core\View\Ajax\View(!in_array(false, $res));
        $view->addData(["panel" => $_POST['panel']]);
        $view->sendResponse();
    }

    /**
     * @param array $array1
     * @param array $array2
     * @return array
     * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
     * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
     */
    public static function array_merge_recursive_distinct(array $array1, array $array2) {
        $merged = $array1;

        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged [$key]) && is_array($merged [$key])) {
                $merged [$key] = self::array_merge_recursive_distinct($merged [$key], $value);
            } else {
                $merged [$key] = $value;
            }
        }

        return $merged;
    }

}
