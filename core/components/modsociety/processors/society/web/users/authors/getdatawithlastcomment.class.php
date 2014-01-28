<?php

//DEPRECATED

ini_set('display_errors',1);
require_once dirname(__FILE__).'/getdata.class.php';
class modWebSocietyUsersAuthorsGetdatawithlastcommentProcessor extends modWebSocietyUsersAuthorsGetdataProcessor{
    
    public function setSelection(xPDOQuery $c){
        $c = parent::setSelection($c);
        
        /* Готовим подзапрос на выборку последних комментов */
        $sc = $this->prepareSubCriteria();
        
        
        $c->select(array(
            "Resource.id as resource_id"
            ,"Resource.content as last_publication"
        ));
        
        $c->leftJoin('modResource','Resource', "
            Resource.createdby = {$this->classKey}.id 
            AND Resource.published = 1 
            AND Resource.deleted = 0 
            AND Resource.id IN (".implode(',',$sc).")
        ");
        
        $c->prepare();
        //print $c->tosql();
        return $c;
    }
    
    protected function prepareSubCriteria(){
        
        $id = $this->modx->user->id;
        
        $c = $this->modx->newQuery('modResource');        
        $c->leftJoin('modUser','',"modUser.id = modResource.createdby");
        
        $c->select(array(
            'MAX(modResource.id) as id'    
        ));
        
        $where = array();
        $where['modUser.id'] = $id;
        
        $c->where($where);

        $ids = array();        
        if($c->prepare() && $c->stmt->execute()){
            while($row = $c->stmt->fetch(PDO::FETCH_ASSOC)){
                $ids[] = $row['id'];
            }
        }
        return $ids;
    }
    
    public function afterIteration(array $list) {        
        $list = parent::afterIteration($list);
        
        foreach($list as $k => & $user){
            
            $pub = $user['last_publication'];            
            if($pub == '') continue;
            
            if(strlen($pub) > 200){
                $pub = substr($pub,0,200).'...';                
                $pub = strip_tags($pub);
            }
            
            $user['last_publication'] = $pub;
            
        }

        return $list;
    }
    
}
return 'modWebSocietyUsersAuthorsGetdatawithlastcommentProcessor';