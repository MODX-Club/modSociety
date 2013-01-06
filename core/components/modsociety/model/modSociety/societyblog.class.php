<?php

require_once MODX_CORE_PATH.'model/modx/modresource.class.php';

class SocietyBlog extends modResource {
    
    public $showInContextMenu = true;
    public $allowChildrenResources = true;
    
    
    public static function getControllerPath(xPDO &$modx) {
        $path = $modx->getOption('modsociety.controller_path',null);
        if(empty($path)){
            $path = $modx->getOption('modsociety.core_path',null, 
                $modx->getOption('core_path', null ). 'components/modsociety/')
                    .'controllers/mgr/';
        }
        $path .= "societyblog/";
        return $path;
    }

    public function getContextMenuText() {
        $this->xpdo->lexicon->load('modsociety:resources');
        return array(
            'text_create' => $this->xpdo->lexicon('modsociety_blog_resource_create'),
            'text_create_here' => $this->xpdo->lexicon('modsociety_blog_resource_create_here'),
        );
    }
    
    public function getResourceTypeName() {
        $this->xpdo->lexicon->load('modsociety:resources');
        return $this->xpdo->lexicon('modsociety_blog_resource');
    } 
}