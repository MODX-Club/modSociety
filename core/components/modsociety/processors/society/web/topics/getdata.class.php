<?php
/*
    Получаем данные топиков
*/

require_once dirname(dirname(__FILE__)) . '/resources/getdata.class.php';

class modWebSocietyTopicsGetdataProcessor extends modSocietyWebResourcesGetdataProcessor{
 
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c = parent::prepareQueryBeforeCount($c);
        
        if($blog = (int)$this->getProperty('blog')){
            /*
                Получаем топики согласно связке топик-блог
            */
            $c->innerJoin('SocietyBlogTopic', 'TopicBlogs', "TopicBlogs.blogid IN ({$blog}) AND TopicBlogs.topicid={$this->classKey}.id");
            
        } 
        
        $c->where(array(
            'class_key'   => 'SocietyTopic',
        ));
        
        return $c;
    }
    
   
    
    protected function setSelection(xPDOQuery $c) {
        $c = parent::setSelection($c);
        
        /*
            Получаем данные диалоговой ветви
        */
        $c->leftJoin('SocietyThread', 'thread', "thread.target_class='modResource' AND thread.target_id={$this->classKey}.id");      
        
        /*
            Проверяем, есть ли голос пользователя здесь
        */
        $c->leftJoin('SocietyVote', 'vote', "vote.target_class='modResource' AND vote.target_id={$this->classKey}.id AND vote.user_id = ". $this->modx->user->id);
        
        $c->leftJoin('modUser', 'CreatedBy'); 
        
        $c->select(array(
            "CreatedBy.username as author_username",
            "thread.id as thread_id",
            "thread.positive_votes",
            "thread.negative_votes",
            "thread.comments_count",
            "vote.id as vote_id",
            "vote.vote_direction",
            "vote.vote_value",
        ));
        
        $c->prepare();
        
        return $c;
    }
    
}

return 'modWebSocietyTopicsGetdataProcessor';