<?php
/*
    Получаем подписчиков юзера
*/
ini_set('display_errors',1);
require_once dirname(dirname(__FILE__)). '/authors/getdata.class.php';

class modWebSocietyUsersSubscribesGetdataProcessor extends modWebSocietyUsersAuthorsGetdataProcessor{
     
    //public $classKey = 'SocietySubscribers';
    
    public function initialize(){
        
        $this->setDefaultProperties(array(
            'subscribe_key'    => 'SocietySubscribers'
        ));
        
        if(!$this->getProperty('user')){
            return 'Не указан пользователь';
        }
        
        return parent::initialize();
    }
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c = parent::prepareQueryBeforeCount($c);
        
        $key = $this->getProperty('subscribe_key');
        
        $c->leftJoin($key, '', "{$key}.userid = {$this->classKey}.id");
        
        $where = array();
        
        // фильтруем по переданному юзеру
        $where[$key.'.subscriberid'] = (int)$this->getProperty('user');
        
        // добавляем возможность найти определенного подписчика
        if($fu = $this->getProperty('foreign_user')){
            $where["{$this->classKey}.username"] = $fu;    
        }
        
        $c->where($where);
        //$c->prepare();print $c->toSQL();
        return $c;
    }
    
    public function setSelection(xPDOQuery $c) {
        $c = parent::setSelection($c);
        
        $key = $this->getProperty('subscribe_key');
        
        $c->select(array(
            "{$key}.subscriberid as subscriber_id",
            "{$key}.rank as rank",
        ));

        return $c;
    }
}

return 'modWebSocietyUsersSubscribesGetdataProcessor';