<?php

/*
    Получаем комментарии
*/

require_once dirname(dirname(dirname(__FILE__))).'/getdata.class.php';


class modSocietyWebThreadsCommentsGetdataProcessor extends modObjectProcessor{
    
    public $classKey = "SocietyComment";
    
    
    public function initialize(){
        
        
        $this->setDefaultProperties(array(
            'includeTVs'    => false,
            "thread_id"     => null,
            "listType"      => "tree",  //  Тип вывода. tree - древовидный, plain - просто по порядку
        ));
        
        return parent::initialize();
    }
    
    
    public function process(){
        
        
        $parent = $this->getProperty('parent', null);
        $thread_id = $this->getProperty('thread_id', null);
        
        $comments = $this->getComments($parent, $thread_id);
        
        
        return $this->outputArray($comments);
    }
    
    
    protected function getComments($parent = null, $thread_id = null){
        $comments = array();
        
        $listType = $this->getProperty('listType');
        
        $c = $this->modx->newQuery($this->classKey);
        
        
        $c->select(array(
            "{$this->classKey}.*",    
        ));
        
        if($listType == 'tree'){
            $where = array(
                'parent' => $parent,
            );
        }
        
        
        if(!$parent && $thread_id){
            $where['thread_id'] = $thread_id;
        }
        
        if($where){
            $c->where($where);
        }
        
        $c->sortby("{$this->classKey}.id", "ASC");
        
        
        if($s = $c->prepare() AND $s->execute()){
            while(
                $row = $s->fetch(PDO::FETCH_ASSOC)
                AND $id = $row['id']
            ){
                $comment = $this->prepareRow($row);
                 
                /*
                    Если вывод древовидный, получаем дочерние комментарии
                */
                if($listType == 'tree'){
                    $comment['children'] = $this->getComments($id);
                }
                
                $comments[] = $comment;
            }
        }
        
        return $comments;
    }
    
    
    protected function prepareRow(array $row){
        
        return $row;
    }
    
    // protected function prepareQuery(){}
    
    protected function getMessage(){return '';}



    public function outputArray(array $array, $count = false){
        
        return array(
            'success' => true,
            'message' => $this->getMessage(),
            'count'   => count($array),
            'total'   => $count,
            'object'  => $array,
        );
    }    
    
}


return 'modSocietyWebThreadsCommentsGetdataProcessor';






class modSocietyWebThreadsCommentsGetdataProcessor___ extends modSocietyWebGetdataProcessor{
    
    
    public function initialize(){
        
        $this->setDefaultProperties(array(
            'includeTVs'    => false,
            "thread"        => null,
        ));
        
        $this->setProperties(array(
            "sort"  => "",
        ));
        
        return parent::initialize();
    }    
    
    
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c = parent::prepareQueryBeforeCount($c);
        
        $c->innerJoin('SocietyThread', "Thread");
        
        $where = array();
        
        /*
            Поиск по ветке диалога
        */
        if($thread = (int)$this->getProperty('thread')){
            $where['thread_id'] = $thread;
        }
        
        /*
            Поиск по цели
        */
        else if(
            $target_id = (int)$this->getProperty('target_id')
            AND $target_class = $this->getProperty('target_class')
        )
        {
            $where['Thread.target_id'] = $target_id;
            $where['Thread.target_class'] = $target_class;
        }
        
        if($where){
            $c->where($where);
        }
        
        return $c;
    }    
    
    
    protected function setSelection(xPDOQuery $c){
        $c = parent::setSelection($c);
        
        $c->leftJoin('modUser', 'Author');
        $c->leftJoin('modUserProfile', 'AuthorProfile', 'Author.id = AuthorProfile.internalKey');
        
        $c->select(array(
            "Author.id as author_id",    
            "Author.username as author_username",    
            "AuthorProfile.fullname as author_fullname",    
        ));
        
        return $c;
    }
    
}

return 'modSocietyWebThreadsCommentsGetdataProcessor';

