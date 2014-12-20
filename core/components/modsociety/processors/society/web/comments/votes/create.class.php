<?php

/*
    Create new vote
*/
require_once dirname(dirname(dirname(__FILE__))).'/votes/create.class.php';
class modSocietyWebCommentsVotesCreateProcessor extends modSocietyWebVotesCreateProcessor{

    public $classKey = 'SocietyVote';
    
    
    public function initialize(){
         
        switch($this->getProperty('vote_direction')){
            case 'up':
                $vote_value = 1;
                break;
            case 'down':
                $vote_value = -1;
                break;
            
        }
        
        $this->setDefaultProperties(array(
            'target_class' => 'SocietyComment'
            ,'vote_value' => $vote_value
        ));
        
        
        return parent::initialize();
    }
    
    public function cleanup(){
        
        $q = $this->modx->newQuery($this->classKey);
        $q->select(array(
            "sum(vote_value) as rating"    
        ));
        $q->where(array(
            "{$this->classKey}.target_id" =>$this->getProperty('target_id')
            ,"target_class" => 'SocietyComment'
        ));
        $this->object->set('rating',$this->modx->getValue($q->prepare()));
        
        return parent::cleanup();
    }
    
}

return 'modSocietyWebCommentsVotesCreateProcessor';

