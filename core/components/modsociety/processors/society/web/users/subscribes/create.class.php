<?php
ini_set('display_errors', 1);
class modSocietyWebUsersSubscribesCreateProcessor extends modObjectCreateProcessor{
    
    public $classKey = 'SocietySubscribers';
    
    public function initialize(){
        
        if(!$this->getProperty('username')){
            return 'Не указан пользователь';
        }
        
        $this->setDefaultProperties(array(
            'userid' => $this->modx->user->id 
            ,"rank" => 0
        ));
        
        return parent::initialize();
    }
    
    public function beforeSave(){
        
        $this->object->fromArray($this->getProperties(),'',true);
        
        return parent::beforeSave();        
    }
    
    public function beforeSet(){
        
        $subscribe = $this->modx->getObject('modUser',array('username'=>$this->getProperty('username')))->get('id');
        $this->setProperty('subscriberid',$subscribe);
        
        $this->unsetProperty('username');
        $this->unsetProperty('ctx');
        $this->unsetProperty('society_action');
        
        return parent::beforeSet();
    }
    
    
}
return 'modSocietyWebUsersSubscribesCreateProcessor';