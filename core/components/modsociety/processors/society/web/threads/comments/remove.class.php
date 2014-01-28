<?php
/*
    Полное удаление комментов
*/

class  modSocietyWebThreadsCommentsRemoveProcessor extends modObjectRemoveProcessor{
    
    public $classKey = 'SocietyComment';
     
    public function initialize(){
          
        if(!$this->modx->hasPermission('delete_comments')){
            return 'Access denied';
        }
        
        if(!$comment_id = (int)$this->getProperty('comment_id')){
            return 'Не был получен ID комментария';
        }
        
        $this->setProperty('id', $comment_id);
        
        return parent::initialize();
    }

}

return 'modSocietyWebThreadsCommentsRemoveProcessor';

