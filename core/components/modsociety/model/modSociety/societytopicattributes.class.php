<?php
class SocietyTopicAttributes extends xPDOSimpleObject {
    
    public function save(){
        if(!$this->get('resource_id')){
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, "Resource ID is null");
            return false;
        }
        return parent::save();
    }
}