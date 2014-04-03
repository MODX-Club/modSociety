<?php

require_once MODX_PROCESSORS_PATH . 'resource/create.class.php';

class modSocietyWebTopicsCreateProcessor extends modResourceCreateProcessor{
    
    public $permission = '';
    
    
    public function initialize(){
        
        $this->setProperties(array(
            'class_key' => 'SocietyTopic',
        ));
        
        
        if(!$this->getProperty('pagetitle')){
            $this->addFieldError('pagetitle', "Не указано название топика");
        }
        
        if(!$this->getProperty('content')){
            $this->addFieldError('content', "Не заполнен текст топика");
        }
        
        if($this->hasErrors()){
            return 'Проверьте правильность заполнения данных';
        }
        
        
        return parent::initialize();
    }
    
    public function beforeSet(){
        
        $canSave = parent::beforeSet();
        if ($canSave !== true) {
            return $canSave;
        }
        
        $this->processAttributes();
        
        return true;
    }
    
    protected function processAttributes(){
        
        $attr = $this->object->getOne('Attributes');
        
        $content = $this->getProperty('content');
        if(!$attr){
          $attr = $this->modx->newObject('SocietyTopicAttributes');
          $attr->fromArray(array(
            'raw_content' => $content,
            'content_hash' => md5($content)
          ));
        }
        
        $this->object->addOne($attr,'Attributes');
        
        return true;
    }
    
}

return 'modSocietyWebTopicsCreateProcessor';

