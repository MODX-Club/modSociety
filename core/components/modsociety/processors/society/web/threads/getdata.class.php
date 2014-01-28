<?php

/*
    Получаем данные диалоговой ветки
*/
//ini_set('display_errors',1);
require_once dirname(dirname(__FILE__)) . '/getdata.class.php';

class modSocietyWebThreadsGetdataProcessor extends modSocietyWebGetdataProcessor{
    
    public $classKey = 'SocietyThread';
    
}

return 'modSocietyWebThreadsGetdataProcessor';

