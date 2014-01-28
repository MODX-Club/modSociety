<?php

/*
    Получаем данные диалоговой ветки
*/


class modSocietyWebThreadsGetProcessor extends modObjectGetProcessor{
    
    public $classKey = 'SocietyThread';
    
    
    public function initialize(){
          
        if(!$thread_id = (int)$this->getProperty('thread_id')){
            
            /*
                Check required data
            */
            if(
                !$target_id = (int)$this->getProperty('target_id')
            ){
                return "Can not get target ID";
            }
            
            if(
                !$target_class = $this->getProperty('target_class', 'modResource')
            ){
                return "Can not get target class";
            }
            
            //else 
            
            /*
                Пытаемся получить ветку диалога по ID цели и классу
            */
            $q = $this->modx->newQuery($this->classKey, array(
                "target_id" => $target_id,
                "target_class" => $target_class,
            ));
            $q->select(array(
                "id",    
            ));
            $q->limit(1);
            
            if(!$s = $q->prepare() OR !$s->execute()){
                return "Request error";
            }
            
            //else
            
            if(!$thread_id = $this->modx->getValue($s)){
                
                
                /*
                    Если не была получена ветка, то пытаемся ее создать
                */
                if(
                    !$response = $this->modx->runProcessor('society/web/threads/create', array(
                        "target_id" => $this->getProperty("target_id"),
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
                        $error =  "Ошибка создания ветви диалога";
                    }
                    
                    $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[- ". __CLASS__ ." -]  {$error}");
                    $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[- ". __CLASS__ ." -] " . print_r($response->getResponse(), true));
                    $this->modx->log(xPDO::LOG_LEVEL_ERROR, "[- ". __CLASS__ ." -] " . print_r($this->getProperties(), true));
                    return $error;
                }
                
                //else 
                
                $thread_id = $thread_data['id'];
                
            }
        }
             
            
        
        $this->setProperty('id', $thread_id);
        
        return parent::initialize();
    }
    
}

return 'modSocietyWebThreadsGetProcessor';

