<?php

/*
    Update comments thread
*/

abstract class modSocietyWebThreadsUpdateProcessor extends modObjectUpdateProcessor{
    
    public $classKey = "SocietyThread";
    
    
    public function initialize(){
        
        // Sanitize post data
        $this->unsetProperty('comments_count');
        $this->unsetProperty('createdon');
        $this->unsetProperty('editedon');
        
        
        
        if(!$thread_id = (int)$this->getProperty('thread_id')){
            
            /*
                Если не была получена ветка, то пытаемся ее создать
            */
            if(
                !$response = $this->modx->runProcessor('society/web/threads/get', array(
                    "target_id" => $this->getProperty("target_id"),
                    "target_class" => $this->getProperty("target_class", "modResource"),
                ), array(
                    "processors_path"   => dirname(dirname(dirname(dirname(__FILE__)))) . '/',
                )
            )){
                $error = "Ошибка выполнения запроса";
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[- ". __CLASS__ ." -]  {$error}");
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[- ". __CLASS__ ." -] " . print_r($this->getProperties(), true));
                return $error;
            }
            
            // else
            if(
                $response->isError() 
                OR !$thread_data = $response->getObject()
            ){
                if(!$error = $response->getMessage()){
                    $error =  "Не были получены данные ветви диалога";
                }
                
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[- ". __CLASS__ ." -]  {$error}");
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[- ". __CLASS__ ." -] " . print_r($response->getResponse(), true));
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[- ". __CLASS__ ." -] " . print_r($this->getProperties(), true));
                return $error;
            }
            
            //else 
            
            $thread_id = $thread_data['id'];
        }
             
        $this->setProperty('id', $thread_id);
         
        return parent::initialize();
    }
    
}

return 'modSocietyWebThreadsUpdateProcessor';

