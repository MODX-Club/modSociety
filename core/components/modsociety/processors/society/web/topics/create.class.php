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
    
}

return 'modSocietyWebTopicsCreateProcessor';

