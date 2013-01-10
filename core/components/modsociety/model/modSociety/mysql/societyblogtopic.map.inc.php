<?php
$xpdo_meta_map['SocietyBlogTopic']= array (
  'package' => 'Society',
  'version' => '1.1',
  'table' => 'society_blog_topic',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'blogid' => NULL,
    'topicid' => NULL,
    'rank' => 0,
  ),
  'fieldMeta' => 
  array (
    'blogid' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
    ),
    'topicid' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
    ),
    'rank' => 
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
    'blogid' => 
    array (
      'alias' => 'blogid',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'blogid' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'topicid' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Blog' => 
    array (
      'class' => 'SocietyBlog',
      'key' => 'id',
      'local' => 'blogid',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Topic' => 
    array (
      'class' => 'SocietyTopic',
      'key' => 'id',
      'local' => 'topicid',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
