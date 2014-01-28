<?php

require_once dirname(dirname(__FILE__)) . '/resources/getdata.class.php';

class modSocietyWebBlogsGetdataProcessor extends modSocietyWebResourcesGetdataProcessor{
    

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c = parent::prepareQueryBeforeCount($c);
        
        $where = array(
            'class_key'     => 'SocietyBlog',
        );
        
        $c->where($where);
        
        return $c;
    }
    
}

return 'modSocietyWebBlogsGetdataProcessor';