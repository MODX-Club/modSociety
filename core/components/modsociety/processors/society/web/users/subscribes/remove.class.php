<?php
ini_set('display_errors', 1);
class modSocietyWebUsersSubscribesRemoveProcessor extends modObjectRemoveProcessor{
    
    public $classKey = 'SocietySubscribers';
    public $checkRemovePermission = false;
    public $primaryKeyField = 'userid';
    
    public function initialize() {
        
        $subid = $this->getProperty('subscriberid'); 
        if(empty($subid)){
            return 'Не удалось получить данные о подписке';
        }
        
        $this->setDefaultProperties(array(
            'userid' => $this->modx->user->id    
        ));

        return $this->_initialize();
    }
    
    // redeclare base method
    public function _initialize(){
                
        $primaryKey = $this->getProperty($this->primaryKeyField,false);
        if (empty($primaryKey)) return $this->modx->lexicon($this->objectType.'_err_ns');
        
        //$this->object = $this->modx->getObject($this->classKey,$primaryKey);
        // redefine base getObject
        $data = array(
            "{$this->primaryKeyField}" => $primaryKey
            ,'subscriberid'             => $this->getProperty('subscriberid')
        );
        
        $this->object = $this->modx->getObject($this->classKey,$data);
        
        if (empty($this->object)) return $this->modx->lexicon($this->objectType.'_err_nfs',array($this->primaryKeyField => $primaryKey));

        if ($this->checkRemovePermission && $this->object instanceof modAccessibleObject && !$this->object->checkPolicy('remove')) {
            return $this->modx->lexicon('access_denied');
        }
        
        return true;
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
return 'modSocietyWebUsersSubscribesRemoveProcessor';