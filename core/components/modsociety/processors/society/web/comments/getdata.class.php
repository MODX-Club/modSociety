<?php

require_once dirname(dirname(__FILE__)) . '/getdata.class.php';

class modSocietyWebCommentsGetdataProcessor extends modSocietyWebGetdataProcessor{
    
    public $classKey = 'SocietyComment';
    
    public function initialize(){
        
        $this->setDefaultProperties(array(
            "sort"  => "id",
            "dir"   => "ASC",
            "getChildIds" => true #allow to get child ids for each comment
        ));
        
        return parent::initialize();
    }
    
    public function prepareQueryBeforeCount(xPDOQuery $q){
        $q = parent::prepareQueryBeforeCount($q);
        
        $q->innerJoin('SocietyThread', 'Thread');
        $q->innerJoin('modUser', 'CreatedBy', "CreatedBy.id = {$this->classKey}.createdby");
        
        if($tid = $this->getProperty('topicId')){
            $q->where(array(
                'Thread.target_id' => $tid
                ,"Thread.target_class" => 'SocietyTopic'
            ));
        }
        
        return $q;
    }
    
    
    public function setSelection(xPDOQuery $q){
        $q = parent::setSelection($q);
        
        $q->innerJoin('modUserProfile', 'CreatedByProfile', "CreatedBy.id = CreatedByProfile.internalKey");
        
        $q->leftJoin('SocietyThread', 'CommentThread', "CommentThread.target_id = {$this->classKey}.id AND CommentThread.target_class = 'SocietyComment'");
        
        $q->select(array(
            "CreatedBy.username as author_username",
            "CreatedByProfile.fullname as author_fullname",
            "CreatedByProfile.photo as author_avatar",
            "CommentThread.rating as thread_rating",
            "CommentThread.positive_votes",
            "CommentThread.negative_votes",
            "CommentThread.neutral_votes",
        ));
        
        
        $vote_table = $this->modx->getTableName('SocietyVote');
        $q->select(array(
            "(select sum(vote_value) from {$vote_table} where {$vote_table}.target_id = {$this->classKey}.id and {$vote_table}.target_class = '{$this->classKey}') as rating" 
        ));
        
        if($this->getProperty('getChildIds')){
            $comments_table = $this->modx->getTableName($this->classKey);
            
            $q->select(array(
                "(select group_concat(id) from {$comments_table} where {$comments_table}.parent = {$this->classKey}.id ) as childs"
            ));

        }
        
        return $q;
    }
    
    public function afterIteration(array $list){
        $_list = parent::afterIteration($list);
        
        $list = array();
        foreach($_list as & $l){
            $list[] = $l;
        }
        
        return $list;
    }
    
}


return 'modSocietyWebCommentsGetdataProcessor';
