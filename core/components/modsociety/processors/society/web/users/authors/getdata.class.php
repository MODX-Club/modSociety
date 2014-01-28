<?php
//ini_set('display_errors',1);
require_once dirname(dirname(__FILE__)).'/getdata.class.php';
class modWebSocietyUsersAuthorsGetdataProcessor extends modWebSocietyUsersGetdataProcessor{
    
    public function prepareQueryBeforeCount(xPDOQuery $c){
        $c = parent::prepareQueryBeforeCount($c);

        $c->innerJoin('modUserGroupMember','UserGroupMembers',"UserGroupMembers.member = {$this->classKey}.id AND UserGroupMembers.user_group = 13");

        return $c;
    }
    
    public function setSelection(xPDOQuery $c){
        $c = parent::setSelection($c);
        
        $c->innerJoin('UsUserProfile','UsProfile', "{$this->classKey}.id = UsProfile.internalKey" );
        
        $c->select(array(
            'UsProfile.first_name',
            'UsProfile.last_name',
            'UsProfile.middle_name',
            'UsProfile.jt_name as nickname',
            'UserGroupMembers.user_group as group_id'    
        ));
        
        return $c;
    }
    
    
    public function afterIteration(array $list){
        
        foreach($list as $k => $user){
            
            //$path = $user['photo'];
            if($user['photo'][0] == '/'){
                //$url = substr($user['photo'],1,strlen($user['photo'])-1);            
                //$path = $this->modx->getOption('base_path') . $url;
            }else{
                $list[$k]['photo'] = '/assets/jokerteam/img/avatars/default.png';
            }
            
        }
        
        return $list;
    }
    
}
return 'modWebSocietyUsersAuthorsGetdataProcessor';