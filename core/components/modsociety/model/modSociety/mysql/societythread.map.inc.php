<?php
$xpdo_meta_map['SocietyThread']= array (
  'package' => 'modSociety',
  'version' => '1.1',
  'table' => 'society_threads',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'target_id' => NULL,
    'target_class' => 'modResource',
    'comments_count' => 0,
    'createdon' => NULL,
    'editedon' => NULL,
    'views' => 0,
    'rating' => 0,
    'positive_votes' => 0,
    'negative_votes' => 0,
    'neutral_votes' => 0,
  ),
  'fieldMeta' => 
  array (
    'target_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'target_class' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => 'modResource',
      'index' => 'index',
    ),
    'comments_count' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'editedon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'views' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'rating' => 
    array (
      'dbtype' => 'float',
      'precision' => '9,3',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'positive_votes' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'negative_votes' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'neutral_votes' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'target_id' => 
    array (
      'alias' => 'target_id',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'target_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'target_class' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
    "composites" => array(
        'Comments' => array (
            'class' => 'SocietyComment',
            'local' => 'id',
            'foreign' => 'thread_id',
            'cardinality' => 'many',
            'owner' => 'local',
        ),
        'Votes' => array (
            'class' => 'SocietyVote',
            'local' => 'id',
            'foreign' => 'thread_id',
            'cardinality' => 'many',
            'owner' => 'local',
        ),
    ),
  "aggregates" => array(),
);
