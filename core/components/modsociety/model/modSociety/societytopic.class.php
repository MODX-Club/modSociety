<?php

require_once MODX_CORE_PATH.'model/modx/modresource.class.php';

class SocietyTopic extends modResource {
    
    public $showInContextMenu = true;
    public $allowChildrenResources = false; 
    
    public $TopicAttributes;

    function __construct(xPDO & $xpdo) {
        parent :: __construct($xpdo);  
    }
    
    
    public static function getControllerPath(xPDO &$modx) {
        $path = $modx->getOption('modsociety.controller_path',null);
        if(empty($path)){
            $path = $modx->getOption('modsociety.core_path',null, 
                $modx->getOption('core_path', null ). 'components/modsociety/')
                    .'controllers/mgr/';
        }
        $path .= "societytopic/";
        return $path;
    }

    public function getContextMenuText() {
        $this->xpdo->lexicon->load('modsociety:resources');
        return array(
            'text_create' => $this->xpdo->lexicon('modsociety_topic_resource_create'),
            'text_create_here' => $this->xpdo->lexicon('modsociety_topic_resource_create_here'),
        );
    }
    
    public function getResourceTypeName() {
        $this->xpdo->lexicon->load('modsociety:resources');
        return $this->xpdo->lexicon('modsociety_topic_resource');
    }
    
    function get($k){
        switch($k){
            case 'url':
                return $this->makeUrl();
                break;
        }
        return parent::get($k);
    }
    
    function makeUrl(){
        if(!$id = $this->get('id')){
            return false;
        }
        return $this->xpdo->getOption('base_url')."topics/{$id}/";
    }
}