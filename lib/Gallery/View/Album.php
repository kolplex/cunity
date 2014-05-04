<?php
namespace Gallery\View;

use Core\View\View;

class Album extends View{
    
    protected $templateDir = "gallery";
    protected $templateFile = "album.tpl";    
    protected $metadata = ["title"=>"Album"];
    
    public function __construct() {
        parent::__construct();
        $this->registerCss("gallery","album");        
        $this->registerScript("gallery", "uploader");        
        $this->registerScript("gallery", "jquery.blueimp-gallery");        
        $this->registerScript("gallery", "album");                    
        $this->registerScript("gallery", "lightbox");                
        $this->registerScript("gallery", "plupload.full");                                
        $this->registerScript("","jquery.jscrollpane");
        $this->registerScript("","jquery.mousewheel");        
    }
}