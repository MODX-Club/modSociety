<?php
class SocietyComment extends xPDOSimpleObject {
    
    /*
        If it`s a new comment, on save update all parent comments and comments thread (recalculate
        total child comments).
    */    
    public function save($cacheFlag= null) {
        
        if($isNew = $this->isNew()){
            
            if(!$this->get('createdon')){
                $this->set('createdon', time());
            }
            
            if(!$this->get('createdby')){
                $this->set('createdby', $this->xpdo->user->id ? $this->xpdo->user->id : null);
            }
            
            $this->set('ip', $this->getUserIP());
            
        }
        
        if(!$this->get('parent')){
            $this->set('parent', null);
        }
        
        /*
        Не делаем так, потому что иначе при обновлении дочерних комментов
        у нас все родительские комменты будут тоже обновленными
        else{
            if(!$this->get('editedon')){
                $this->set('editedon', time());
            }
        }*/
        
        $rt= parent :: save($cacheFlag);
        
        /*
            If saved and it`s was new comment, recalculate total comments
        */
        if ($rt && $isNew) {
            $this->recalculateParentComments(1);
        }
        
        return $rt;
    }    
    
    
    public function remove(array $ancestors= array ()) {
        $rm = $this->__remove($ancestors);
        
        if($rm){
            
            if(!$this->get('parent')){
                if($tread = $this->getOne('Thread')){
                    //$tread->set('comments_count', $tread->get('comments_count') - ($this->get('comments_count') + 1));
                    $tread->set('comments_count', $tread->get('comments_count') - 1);
                    $tread->save();
                }
                
                /*print_r($tread->toArray());
                print_r($this->toArray());*/
            }
            else{
                $this->recalculateParentComments(-1);
            }
        }
        
        
        /*
            При пересчет учитываются только родители, поэтому если это коммент первого
            уровня, то отнимаем дополнительно еще одно очко счетчика ветки
        */
        /*
        */
        
        return $rm;
    }
    
    
    public function __remove(array $ancestors= array ()) {
        
        // print_r($ancestors);
        
        $result= false;
        $pk= $this->getPrimaryKey();
        if ($pk && $this->xpdo->getConnection(array(xPDO::OPT_CONN_MUTABLE => true))) {
            if (!empty ($this->_composites)) {
                $current= array ($this->_class, $this->_alias);
                foreach ($this->_composites as $compositeAlias => $composite) {
                    if (in_array($compositeAlias, $ancestors) || in_array($composite['class'], $ancestors)) {
                        print 'ancestors';
                        // continue;
                    }
                    if ($composite['cardinality'] === 'many') {
                        if ($many= $this->getMany($compositeAlias)) {
                            foreach ($many as $one) {
                                $ancestors[]= $compositeAlias;
                                $newAncestors= $ancestors + $current;
                                if (!$one->remove($newAncestors)) {
                                    $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, "Error removing dependent object: " . print_r($one->toArray('', true), true));
                                }
                            }
                            unset($many);
                        }
                    }
                    elseif ($one= $this->getOne($compositeAlias)) {
                        $ancestors[]= $compositeAlias;
                        $newAncestors= $ancestors + $current;
                        if (!$one->remove($newAncestors)) {
                            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, "Error removing dependent object: " . print_r($one->toArray('', true), true));
                        }
                        unset($one);
                    }
                }
            }
            $delete= $this->xpdo->newQuery($this->_class);
            $delete->command('DELETE');
            $delete->where($pk);
            // $delete->limit(1);
            $stmt= $delete->prepare();
            if (is_object($stmt)) {
                if (!$result= $stmt->execute()) {
                    $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Could not delete from ' . $this->_table . '; primary key specified was ' . print_r($pk, true) . "\n" . print_r($stmt->errorInfo(), true));
                } else {
                    $callback = $this->getOption(xPDO::OPT_CALLBACK_ON_REMOVE);
                    if ($callback && is_callable($callback)) {
                        call_user_func($callback, array('className' => $this->_class, 'criteria' => $delete, 'object' => $this));
                    }
                    if ($this->xpdo->_cacheEnabled) {
                        $cacheKey= is_array($pk) ? implode('_', $pk) : $pk;
                        $this->xpdo->toCache($this->xpdo->getTableClass($this->_class) . '_' . $cacheKey, null, 0, array('modified' => true));
                    }
                    $this->xpdo->log(xPDO::LOG_LEVEL_INFO, "Removed {$this->_class} instance with primary key " . print_r($pk, true));
                }
            } else {
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Could not build criteria to delete from ' . $this->_table . '; primary key specified was ' . print_r($pk, true));
            }
        }
        return $result;
    }    
    
    
    
    /*
        Recalculate parent comments
    */
    protected function recalculateParentComments($quantity) {
        
        $comment = $this;
        
        // Recalculate parent comments
        while($parent = $this->xpdo->getObject($this->_class, $comment->parent)){
            
            $parent->set('comments_count', $parent->get('comments_count') + $quantity);
            $parent->save();
            
            $comment = $parent;
        }
        
        // recalculate thread comments
        $this->recalculateThreadComment();
            
        return;    
    }    
    
    protected function recalculateThreadComment(){
        // Recalculate total comments in tread
        if($tread = $this->getOne('Thread')){
            
            $q = $this->xpdo->newQuery($this->_class, array(
                "thread_id"  => $this->get('thread_id'),
                "parent"    => null,
            ));
            $q->select(array(
                "comments_count",    
            ));
            
            if($s = $q->prepare() AND $s->execute()){
                $total = 0;
                while($row = $s->fetch(PDO::FETCH_ASSOC)){
                    $total++;
                    $total += $row['comments_count'];
                }
                
                $tread->set('comments_count', $total);
                $tread->save();
            }
        }
        return;
    }
    
    protected function getUserIP(){
        $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

}