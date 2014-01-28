<?php

require_once MODX_PROCESSORS_PATH . 'resource/create.class.php';

class modSocietyWebBlogsCreateProcessor extends modResourceCreateProcessor{
    
    public $permission = '';
    
    
    public function initialize(){
        $this->setProperties(array(
            'class_key' => 'SocietyBlog',
        ));
        
        return parent::initialize();
    }
}

return 'modSocietyWebBlogsCreateProcessor';

