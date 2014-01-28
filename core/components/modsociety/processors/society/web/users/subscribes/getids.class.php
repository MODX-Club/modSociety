<?php
/*
    Получаем данные по подписке
*/
ini_set('display_errors',1);
require_once dirname(__FILE__). '/getdata.class.php';

class modWebSocietyUsersSubscribesGetidsProcessor extends modWebSocietyUsersSubscribesGetdataProcessor{
        
    public function afterIteration(array $list) {

        //print_r($list);
        $_list = parent::afterIteration($list);
        $list = array();
        
        foreach($_list as & $l){
            $list[] = $l['object_id'];
        }
        
        return $list;
    }

}

return 'modWebSocietyUsersSubscribesGetidsProcessor';