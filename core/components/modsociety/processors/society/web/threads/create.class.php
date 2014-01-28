<?php

/*
    Создаем новую диалоговую ветвь
*/

class modSocietyWebThreadsCreateProcessor extends modObjectCreateProcessor{
    
    public $classKey = 'SocietyThread';
    
    public function initialize(){
        
        $this->setDefaultProperties(array(
            "target_class"  => "modResource",
        ));
        
        if(!(int)$this->getProperty('target_id')){
            return 'Не был указан ID целевого объекта';
        }
        
        if(!$this->getProperty('target_class')){
            return 'Не был указан класс целевого объекта';
        }
        
        return parent::initialize();
    }
}

return 'modSocietyWebThreadsCreateProcessor';