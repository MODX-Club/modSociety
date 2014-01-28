<?php

//require_once MODX_PROCESSORS_PATH . 'resource/update.class.php';

class modSocietyWebTopicsUpdateProcessor extends modObjectUpdateProcessor{
    
    public $permission = '';
    public $classKey = 'SocietyTopic';
    
    public function initialize(){
        
        if(!$this->getProperty('id')){
            $this->addFieldError('id', "Не указан id топика");
        }
        
        if($this->hasErrors()){
            return 'Проверьте правильность заполнения данных';
        }
        
        return parent::initialize();
    }
    
}

return 'modSocietyWebTopicsUpdateProcessor';

