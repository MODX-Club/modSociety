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
        return $modx->getOption('modsociety.core_path',null,$modx->getOption('core_path').'components/modsociety/').'controllers/mgr/societytopic/';
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
    
    function remove(){
        // $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Нельзя удалять топики');
        if($this->getTopicAttributes()){
            if(!$this->TopicAttributes->remove()){
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, "Не удалось удалить атрибуты топика");
                return false;
            }
        }
        return parent::remove();
    }
    
    public function save(){
        if($this->isNew()){
            if(!$this->newAttributes()){
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Не удалось создать атрибуты документа');
                return false;
            }
            if(!parent::save()){
                return false;
            }
            $this->TopicAttributes->set('resource_id', $this->get('id'));
            
            if(!$this->TopicAttributes->save()){
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Не удалось сохранить атрибуты документа');
                return false;
            }
        }
        else{
            if(!$this->TopicAttributes){
                $this->TopicAttributes = $this->getTopicAttributes();
            }
        }
        
        if(!$this->TopicAttributes && !$this->get('deleted')){
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Не были получены атрибуты документа');
            return false;
        }
        
        return parent::save();
    }
    
    public function newAttributes(){
        $this->TopicAttributes = $this->xpdo->newObject('SocietyTopicAttributes');
        return $this->TopicAttributes;
    }
    
    public function getTopicAttributes($id = null){
        if(!$id){
            $id = $this->get('id');
        }
        $this->TopicAttributes = $this->xpdo->getObject('SocietyTopicAttributes', array(
            'resource_id'   => $id,
        ));
        return $this->TopicAttributes;
    }
     
}