<?php

require_once dirname(__FILE__).'/getlist.class.php';

class modWebSocietyUsersGetdataProcessor extends modWebSocietyUsersGetlistProcessor{
    
    public function initialize(){
        
        $this->setDefaultProperties(array(
            'getPage'           => false,
            'limit'             => 15,
            'page'              => !empty($_REQUEST['page']) ? (int)$_REQUEST['page'] : 0,
        ));
        
        if($this->getProperty('noPagi')){
            $this->setProperty('getPage',false);
            $this->setProperty('limit',0);
            $this->setProperty('page',0);
        }
        
        if($page = $this->getProperty('page') AND $page > 1 AND $limit = $this->getProperty('limit', 0)){
            $this->setProperty('start', ($page-1) * $limit);
        }
        
        return parent::initialize();
    }
    
    public function prepareQueryBeforeCount(xPDOQuery $c){
        $c = parent::prepareQueryBeforeCount($c);
        
        
        $c->leftJoin('modUserProfile','Profile',"{$this->classKey}.id = Profile.internalKey");
        
        $where = array();
        
        if(!$this->getProperty('active', false)){
            $where['active'] = 1;
        }
        
        if(!$this->getProperty('blocked', false)){
            $where['Profile.blocked'] = 0;
        }
        
        if(count($where) > 0){
            $c->where($where);
        }
        
        return $c;
    }
    
    protected function getResults(xPDOQuery & $c){
        $list = array();
        $this->currentIndex = 0;
        if($c->prepare() && $c->stmt->execute()){
            while($row = $c->stmt->fetch(PDO::FETCH_ASSOC)){
                $object_id = $row['object_id'];
                if(empty($list[$object_id])){
                    $list[$object_id] = $row;
                    $this->currentIndex++;
                }
            }
        }
        return $list;
    }
    
    /*public function iterate(array $data) {
        $list = $this->beforeIteration($data['results']);
        $list = $this->afterIteration($list);
        return $list;
    } */   
    
    protected function setSelection(xPDOQuery $c){
        $c = parent::setSelection($c);
        
        $c->select(array(
            "Profile.*",
        ));

        return $c;
    }
    
    public function outputArray(array $array, $count = false) {
        if($this->getProperty('getPage') AND $limit = $this->getProperty('limit')){
            $this->modx->setPlaceholder('total', $count);
            $this->modx->runSnippet('getPage@jt_pagination', array(
                'limit' => $limit,
            ));
        }
        return parent::outputArray($array, $count);
    }
      
}
return 'modWebSocietyUsersGetdataProcessor';