<?php

/*
    Create new vote
*/

class modSocietyWebVotesCreateProcessor extends modObjectCreateProcessor{

    public $classKey = 'SocietyVote';
    
    
    public function initialize(){
         
        if(!$this->modx->user->id){
            return 'Необходимо авторизоваться';
        }
        
        $this->setDefaultProperties(array(
            'vote_direction'    => 0,
            'vote_value'        => 0.000,
        ));
        
        $vote_value = (float)$this->getProperty('vote_value');
        
        if($vote_value > 0){
            $this->setProperty('vote_direction', '1');
        }
        else if($vote_value < 0){
            $this->setProperty('vote_direction', '-1');
        }
        
        $this->setProperties(array(
            "user_id"       => $this->modx->user->id,
            "vote_date"     => time(),
        ));
        
        return parent::initialize();
    }
      
    
    public function beforeSave(){
        
        /*
            Если указан ID диалоговой ветки, то пытаемся ее получить
        */
        if($thread_id = (int)$this->getProperty('thread_id')){
            
            // Если ветка не была получена, то ошибка
            if(!$thread = $this->object->getOne('Thread')){
                return 'Не была получена диалоговая ветка';
            }
            
            // else
            // Иначе устанавливаем голосу id и класс целевого объекта
            $this->object->fromArray(array(
                "target_id"     => $thread->get('target_id'),
                "target_class"  => $thread->get('target_class'),
            ));
            
            /*
                Пометка. На этом этапе хорошо бы проверять права на голосование за этот объект
            */
        }
        
        else if(!$target_id = (int)$this->getProperty('target_id')){
            return 'Не был получен ID целевого  объекта';
        }
        
        else if(!$target_class = $this->getProperty('target_class')){
            return 'Не был получен класс целевого  объекта';
        }
        
        // Иначе пытаемся получить диалоговую ветку по этим id и классу объекта
        // Или целевой объект. Если не был получен, возвращаем ошибку
        else if(
            !$thread = $this->object->getOne('Thread', array(
                "target_id"     => $target_id,
                "target_class"  => $target_class,
            ))
            AND !$this->modx->getCount($target_class, $target_id)
        ){
            return "Не был получен целевой объект";
        }
        
        /*
            Если есть объект диалоговой ветки,
            обновляем рейтинг, а так же счетчики общего числа голосов
        */
        if($thread){
            $thread->set('rating', $thread->get('rating') + $this->getProperty('vote_value'));
            
            if($this->getProperty('vote_direction') == '1'){
                $thread->set('positive_votes', $thread->get('positive_votes') + 1);
            }
            else if($this->getProperty('vote_direction') == '-1'){
                $thread->set('negative_votes', $thread->get('negative_votes') + 1);
            }
            else{
                $thread->set('neutral_votes', $thread->get('neutral_votes') + 1);
            }
        }
        
        // Проверяем, чтобы этот пользователь еще не голосовал
        $q = $this->modx->newQuery($this->classKey, array(
            "user_id"   => $this->getProperty('user_id'),
            "target_id" => $this->object->get('target_id'),
            "target_class" => $this->object->get('target_class'),
        )); 
        $q->select(array(
            "id"    
        ));
        $q->limit(1);
        
        if($s = $q->prepare() AND $this->modx->getValue($s)){
            return "Вы не можете голосовать дважды за один и тот же объект";
        }  
            
        return parent::beforeSave();
    }
    
}

return 'modSocietyWebVotesCreateProcessor';

