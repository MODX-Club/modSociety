<?php
/*
    Базовый класс для выборки документов
*/ 

require_once MODX_CORE_PATH.'components/modxsite/processors/site/web/getdata.class.php';



class modSocietyWebGetdataProcessor extends modSiteWebGetdataProcessor{
    
    
    public function initialize(){
        
        $this->setDefaultProperties(array(
            'includeTVs'  => false,  
        ));
        
        return parent::initialize();
    }
}

 
return 'modSocietyWebGetdataProcessor';



    