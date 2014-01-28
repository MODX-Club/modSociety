<?php
$xpdo_meta_map['SocietyVote']= array (
  'package' => 'modSociety',
  'version' => '1.1',
  'table' => 'society_votes',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'target_id' => NULL,
    'target_class' => NULL,
    'thread_id' => NULL,
    'user_id' => NULL,
    'vote_direction' => '0',
    'vote_value' => 0,
    'vote_date' => 'CURRENT_TIMESTAMP',
  ),
  'fieldMeta' => 
  array (
    'target_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'index',
    ),
    'target_class' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'thread_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
    ),
    'vote_direction' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'-1\',\'0\',\'1\'',
      'phptype' => 'string',
      'null' => false,
      'default' => '0',
    ),
    'vote_value' => 
    array (
      'dbtype' => 'float',
      'precision' => '9,3',
      'phptype' => 'float',
      'null' => false,
      'default' => 0,
    ),
    'vote_date' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
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
          'null' => false,
        ),
        'target_class' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'user_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'thread_id' => 
    array (
      'alias' => 'thread_id',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'thread_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'user_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
    "aggregates" => array(
        "Thread" => array(
            'class' => 'SocietyThread',
            'local' => 'thread_id',
            'foreign' => 'id',
            'cardinality' => 'one',
            'owner' => 'foreign',
        ),
        "Voter" => array(
            'class' => 'modUser',
            'local' => 'user_id',
            'foreign' => 'id',
            'cardinality' => 'one',
            'owner' => 'foreign',
        ),
    ),
);
