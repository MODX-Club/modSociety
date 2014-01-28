<?php

/*
    Процессор, определяющий по запрошенному действию какой процессор выполнять
*/

 ini_set('display_errors', 1);

class modSocietyWebPublicActionProcessor extends modProcessor{
    
    public static function getInstance(modX &$modx,$className,$properties = array()) {
        $actualClass = '';
        // Здесь мы имеем возможность переопределить реальный класс процессора
        if(!empty($properties['society_action'])){
             
            switch($properties['society_action']){
                
                case 'comments/add': 
                    require dirname(dirname(__FILE__)) . '/threads/comments/create.class.php';                    
                    $actualClass =  'modSocietyWebThreadsCommentsCreateProcessor';
                    break;
                case 'comments/hide': 
                case 'comments/edit':  
                    require dirname(dirname(__FILE__)) . '/threads/comments/update.class.php';                    
                    $actualClass =  'modSocietyWebThreadsCommentsUpdateProcessor';
                    break;
                case 'comments/remove':  
                    require dirname(dirname(__FILE__)) . '/threads/comments/remove.class.php';                    
                    $actualClass =  'modSocietyWebThreadsCommentsRemoveProcessor';
                    break;
                case 'bcomments/getdiffs':  
                    require dirname(dirname(__FILE__)) . '/threads/broadcastcomments/getdiffs.class.php';                    
                    $actualClass =  'modSocietyWebThreadsBroadcastcommentsGetdiffsProcessor';
                    break;
                case 'bcomments/getdiffnodes':                      
                    require dirname(dirname(__FILE__)) . '/threads/broadcastcomments/getdiffnodes.class.php';                    
                    $actualClass =  'modSocietyWebThreadsBroadcastcommentsGetdiffnodesProcessor';
                    break;
                case 'bcomments/edit':                      
                    require dirname(dirname(__FILE__)) . '/threads/broadcastcomments/update.class.php';                    
                    $actualClass =  'modSocietyWebThreadsBroadcastcommentsUpdateProcessor';
                    break;
                case 'bcomments/remove':                      
                    require dirname(dirname(__FILE__)) . '/threads/broadcastcomments/remove.class.php';                    
                    $actualClass =  'modSocietyWebThreadsBroadcastcommentsRemoveProcessor';
                    break;
                case 'topics/update':                      
                    require dirname(dirname(__FILE__)) . '/topics/update.class.php';                    
                    $actualClass =  'modSocietyWebTopicsUpdateProcessor';
                    break;
                /*case 'subscribe/update':                      
                    require dirname(dirname(__FILE__)) . '/users/subscribes/update.class.php';                    
                    $actualClass =  'modSocietyWebUsersSubscribesUpdateProcessor';
                    break;*/
                case 'subscribe/create':                      
                    require dirname(dirname(__FILE__)) . '/users/subscribes/create.class.php';                    
                    $actualClass =  'modSocietyWebUsersSubscribesCreateProcessor';
                    break;
                case 'subscribe/remove':                      
                    require dirname(dirname(__FILE__)) . '/users/subscribes/remove.class.php';                    
                    $actualClass =  'modSocietyWebUsersSubscribesRemoveProcessor';
                    break;
                
                default:;
            }
             
        }  
        
        if($actualClass){
            $className = $actualClass;
            unset($properties['society_action']);
        }
        
        return parent::getInstance($modx,$className,$properties);
    }    
     
    
    public function process(){
        $error = 'Действие не существует или не может быть выполнено';
        $this->modx->log(xPDO::LOG_LEVEL_ERROR, __CLASS__ . " - {$error}");
        $this->modx->log(xPDO::LOG_LEVEL_ERROR, print_r($this->getProperties(), true));
        return $this->failure($error);
    }
    
}

return 'modSocietyWebPublicActionProcessor';