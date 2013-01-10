<?php
class SocietyBlogTopic extends xPDOObject {
    
    public function save(){
        if((!$this->get('topicid') && empty($this->_relatedObjects['Topic'])) OR 
                (!$this->get('blogid') && empty($this->_relatedObjects['Blog']))){
            return false;
        }
        return  parent::save();
    }
}