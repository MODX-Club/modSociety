<?php
class SocietyThread extends xPDOSimpleObject {
    
    public function save($cacheFlag= null) {
        
        if($isNew = $this->isNew()){
            
            if(!$this->get('createdon')){
                $this->set('createdon', time());
            }
             
        }
        /*
        Убираем автоматический апдейт, так как у нас будут сохранения при новых рейтингах и просмотрах
        else{
            if(!$this->get('editedon')){
                $this->set('editedon', time());
            }
        }*/
         
        
        return parent :: save($cacheFlag);
    }    
        
    
}