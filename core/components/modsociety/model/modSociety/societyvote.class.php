<?php
class SocietyVote extends xPDOSimpleObject{
     
    
    public function remove(array $ancestors= array ()) {
         
        $ok = parent::remove($ancestors);
        
        if($ok){
            
            if($thread = $this->Thread){
                
                switch($this->vote_direction){
                    
                    case '1':
                        $thread->positive_votes = $thread->positive_votes - 1;
                        break;
                        
                    case '-1':
                        $thread->negative_votes = $thread->negative_votes - 1;
                        break;
                    default:
                        $thread->neutral_votes = $thread->neutral_votes - 1;
                        ;
                    
                } 
                
                $thread->rating = $thread->rating - ($this->vote_value);
                
                $thread->save();
            }
            
        }
        
        
        return $ok;
    }

}
