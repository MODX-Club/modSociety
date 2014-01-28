<?php
$xpdo_meta_map['SocietyComment']= array (
  'package' => 'modSociety',
  'version' => '1.1',
  'table' => 'society_comments',
  'extends' => 'xPDOSimpleObject',
  'fields' => array (
    'thread_id' => NULL,
    'parent' => NULL,
    'text' => NULL,
    'raw_text' => NULL,
    'ip' => '0.0.0.0',
    'createdon' => NULL,
    'createdby' => NULL,
    'editedon' => NULL,
    'editedby' => NULL,
    'published' => '1',
    'deleted' => '0',
    'deletedon' => NULL,
    'deletedby' => NULL,
    'comments_count' => 0,
    'properties' => NULL,
  ),
  'fieldMeta' => 
  array (
    'thread_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'parent' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'text' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
    ),
    'raw_text' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
    ),
    'ip' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '16',
      'phptype' => 'string',
      'null' => false,
      'default' => '0.0.0.0',
    ),
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'createdby' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'editedon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'editedby' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'published' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'0\',\'1\'',
      'phptype' => 'string',
      'null' => false,
      'default' => '1',
    ),
    'deleted' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'0\',\'1\'',
      'phptype' => 'string',
      'null' => false,
      'default' => '0',
      'index' => 'index',
    ),
    'deletedon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'deletedby' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
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
    'properties' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'array',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'parent' => 
    array (
      'alias' => 'parent',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'parent' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'deleted' => 
    array (
      'alias' => 'deleted',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'deleted' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'target_id' => 
    array (
      'alias' => 'target_id',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'thread_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'createdby' => 
    array (
      'alias' => 'createdby',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'createdby' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'editedby' => 
    array (
      'alias' => 'editedby',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'editedby' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'deletedby' => 
    array (
      'alias' => 'deletedby',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'deletedby' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
    "composites" => array(
        'Children' => array (
          'class' => 'SocietyComment',
          'local' => 'id',
          'foreign' => 'parent',
          'cardinality' => 'many',
          'owner' => 'local',
        ),
    ),
    "aggregates" => array(
        "Parent" => array(
            'class' => 'SocietyComment',
            'local' => 'parent',
            'foreign' => 'id',
            'cardinality' => 'one',
            'owner' => 'foreign',
        ),
        "Thread" => array(
            'class' => 'SocietyThread',
            'local' => 'thread_id',
            'foreign' => 'id',
            'cardinality' => 'one',
            'owner' => 'foreign',
        ),
        "Author" => array(
            'class' => 'modUser',
            'local' => 'createdby',
            'foreign' => 'id',
            'cardinality' => 'one',
            'owner' => 'foreign',
        ),
    ),
);



