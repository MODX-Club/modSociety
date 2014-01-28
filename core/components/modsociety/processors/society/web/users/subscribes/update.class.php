<?php

// DEPRECATED
class modSocietyWebUsersSubscribesUpdateProcessor extends modObjectUpdateProcessor{
    
    public $classKey = 'SocietySubscribers';
    
    public function initialize(){
        
        if(!$this->getProperty('username')){
            return 'Не указан пользователь';
        }
        
        return parent::initialize();
    }
    
    
}
return 'modSocietyWebUsersSubscribesUpdateProcessor';