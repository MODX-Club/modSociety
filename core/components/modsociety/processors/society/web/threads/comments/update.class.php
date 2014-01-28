<?php
/*
    Редактирование комментов
*/

class  modSocietyWebThreadsCommentsUpdateProcessor extends modObjectUpdateProcessor{
    
    public $classKey = 'SocietyComment';
    
    
    public function initialize(){

        // Sanitize post data
        $this->unsetProperty('thread_id');
        $this->unsetProperty('parent');
        $this->unsetProperty('ip');
        $this->unsetProperty('createdon');
        $this->unsetProperty('createdby');
        $this->unsetProperty('editedon');
        $this->unsetProperty('editedby');
        $this->unsetProperty('deletedon');
        $this->unsetProperty('deletedby');
        $this->unsetProperty('comments_count');
        $this->unsetProperty('properties');
        
        if(!$this->modx->user->isAuthenticated($this->modx->context->key)){
            return 'Unauthorized';
        }
        
        if(!$comment_id = (int)$this->getProperty('comment_id')){
            return 'Не был получен ID комментария';
        }
        
        $this->setProperty('id', $comment_id);
        
        return parent::initialize();
    }
    
    
    public function beforeSet(){
        /*
            Если нет прав на модерацию и пользователь не является владельцем,
            то редактировать комментарий нельзя
        */
        if(
            !$this->modx->hasPermission('moderate_comments')
            AND $this->object->getOne('Author')->id != $this->modx->user->id
        ){
            return 'Access denied';
        }
        
        // Если удаляется
        if(
            $this->getProperty('deleted')
            AND !$this->object->get('deleted')
        ){
            $this->setProperties(array(
                "deletedon" => time(),
                "deletedby" => $this->modx->user->id,
            ));
            
        }
        
        // Если отменяется удаление
        else if(
            $this->getProperty('restore')
        ){
            $this->setProperties(array(
                "deleted" => 0,
                "deletedon" => null,
                "deletedby" => null,
            ));
            
        }
        
        
        
        return parent::beforeSet();
    }
    
    
    public function beforeSave(){
        
        /*print_r($this->object->toArray());
        
        exit;*/
        
        return parent::beforeSave();
    }
    
}

return 'modSocietyWebThreadsCommentsUpdateProcessor';

