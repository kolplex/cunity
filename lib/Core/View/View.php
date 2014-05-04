<?php

namespace Core\View;

use Core\Exception;

require_once 'Smarty.class.php';

class View extends \Smarty {

    protected $templateRoot = "../style/%design%/modules/";
    protected $templateCache = "../data/temp/templates-cache/";
    protected $templateCompiled = "../data/temp/templates-compiled/";
    protected $useWrapper = true;
    protected $wrapper = "Core/out_wrap.tpl";
    protected $templateDir = "";
    protected $templateFile = "";
    protected $languageFolder = "Core/languages/";
    protected $headScripts = [];
    protected $headCss = [];
    protected $metadata = ["title" => "A page", "description" => "Cunity - Your private social network"];
    public static $zt;

    public function __construct() {
        parent::__construct();
        if (!file_exists("../style/" . $this->getSetting("design")))
            throw new \Exception("Cannot find Theme-Folder \"" . $this->getSetting("design") . "\"");
        $this->templateRoot = str_replace("%design%", $this->getSetting("design"), $this->templateRoot);
        $this->setTemplateDir($this->templateRoot);
        $this->setCompileDir($this->templateCompiled);
        $this->setCacheDir($this->templateCache);
        $this->left_delimiter = "{-";
        $this->debugging = \Core\Cunity::get("config")->site->tpl_debug;
        $this->registerPlugin("modifier", "translate", [$this, "translate"]);
        $this->registerPlugin("modifier", "setting", [$this, "getSetting"]);
        $this->registerPlugin("modifier", "config", [$this, "getConfig"]);
        $this->registerPlugin("modifier", "image", [$this, "convertImage"]);
        $this->registerPlugin("modifier", "URL", [$this, 'convertUrl']);
        $this->templateDir = ucfirst($this->templateDir);
        //$this->initTranslator();
    }

    public function setMetaData(array $meta) {
        $this->metadata = $meta;
    }

    public static function convertUrl($urlString) {
        return \Core\Models\Generator\Url::convertUrl($urlString);
    }

    public function convertImage($filename, $type, $prefix = "") {
        if ($filename == NULL || empty($filename))
            return $this->getSetting("siteurl") . "style/" . $this->getSetting("design") . "/img/placeholders/noimg-" . $type . ".png";
        return $this->getSetting("siteurl") . "data/uploads/" . $this->getSetting("filesdir") . "/" . $prefix . $filename;
    }

    private function initTranslator() {
        $locale = new \Zend_Locale();
        self::$zt = new \Zend_Translate([
            'adapter' => 'gettext',
            'locale' => 'auto',
            'content' => "Core/languages/", // $this->languageFolder,
            'scan' => \Zend_Translate::LOCALE_FILENAME
        ]);
        self::$zt->setOptions([
            'log' => new \Zend_Log(new \Zend_Log_Writer_Stream('missing-translations.log')),
            'logUntranslated' => true]);
        if (!self::$zt->isAvailable($locale->getLanguage()))
            self::$zt->setLocale(self::$defaultLanguage);
        self::$zt->getLocale();
    }

    public function useWrapper($value) {
        $this->useWrapper = ($value === true);
    }

    protected function registerScript($module, $scriptName) {
        $module = (!empty($module)) ? ucfirst($module) : "..";
        if (file_exists($this->templateRoot . $module . "/javascript/" . $scriptName . ".min.js"))
            $this->headScripts[] = '<script src="' . $this->getSetting("siteurl") . substr($this->templateRoot . $module . "/javascript/" . $scriptName . ".min.js", 3) . '"></script>';
        else if (file_exists($this->templateRoot . $module . "/javascript/" . $scriptName . ".js"))
            $this->headScripts[] = '<script src="' . $this->getSetting("siteurl") . substr($this->templateRoot . $module . "/javascript/" . $scriptName . ".js", 3) . '"></script>';
        else
            throw new Exception("Cannot load javascript-file: '" . $scriptName . "'");
    }

    protected function registerCss($module, $fileName) {
        $module = (!empty($module)) ? ucfirst($module) : "..";
        if (file_exists($this->templateRoot . $module . "/css/" . $fileName . ".css"))
            $this->headCss[] = $module . "/css/" . $fileName;
        else
            throw new Exception("Cannot load CSS-file: '" . $fileName . "'");
    }

    public function show() {
        if (\Register\Models\Login::loggedIn() && $_GET['m'] !== "admin") {
            $this->registerScript("search", "livesearch");
            $this->registerScript("messages", "message-modal");
            $this->registerScript("friends", "friends");
        }
        $this->metadata["module"] = $_GET['m'];
        $this->assign("meta", $this->metadata);
        $this->assign('script_head', implode("\n", $this->headScripts));
        $this->assign('css_head', base64_encode(implode(",", $this->headCss)));
        $this->assign('modrewrite', (int) \Core\Cunity::get("mod_rewrite"));
        $this->assign('user', (\Register\Models\Login::loggedIn()) ? $_SESSION['user']->getTable()->get($_SESSION['user']->userid) : []);
        $this->assign('menu', new \Core\Models\Db\Table\Menu());
        if ($this->useWrapper) {
            $this->assign('tpl_name', $this->templateDir . DIRECTORY_SEPARATOR . $this->templateFile);
            $this->display($this->wrapper);
        } else
            $this->display($this->templateDir . DIRECTORY_SEPARATOR . $this->templateFile);
    }

    public static function translate($string, $replaces = []) {
        return vsprintf($string, $replaces);
        return vsprintf(self::$zt->_($string, $replaces));
    }    

    public function getSetting($settingname) {
        return \Core\Cunity::get("settings")->getSetting($settingname);
    }

}
