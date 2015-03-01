<?php

$xpdo_meta_map = array (
  'modResource' => 
  array (
    0 => 'SocietyTopic',
    1 => 'SocietyBlog',
  ),
  'xPDOSimpleObject' => 
  array (
    0 => 'SocietyComment',
  ),
  'xPDOObject' => 
  array (
    0 => 'SocietySubscribers',
  ),
);

$this->map['modUser']['composites']['Comments'] = array(
    'class' => 'SocietyComment',
    'local' => 'id',
    'foreign' => 'createdby',
    'cardinality' => 'many',
    'owner' => 'local',
);

$this->map['modUser']['composites']['Votes'] = array(
    'class' => 'SocietyVote',
    'local' => 'id',
    'foreign' => 'user_id',
    'cardinality' => 'many',
    'owner' => 'local',
);
