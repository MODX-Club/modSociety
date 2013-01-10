<?php
$xpdo_meta_map['SocietyBlogAttributes']= array (
  'package' => 'modSociety',
  'version' => '1.1',
  'table' => 'society_blog_attributes',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'resourceid' => NULL,
    'content_hash' => NULL,
  ),
  'fieldMeta' => 
  array (
    'resourceid' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'unique',
    ),
    'content_hash' => 
    array (
      'dbtype' => 'char',
      'precision' => '32',
      'phptype' => 'string',
      'null' => true,
      'index' => 'unique',
    ),
  ),
  'aggregates' => 
  array (
    'Blog' => 
    array (
      'class' => 'SocietyBlog',
      'local' => 'resourceid',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),    
  'indexes' => 
  array (
    'resourceid' => 
    array (
      'alias' => 'resourceid',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'resourceid' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'content_hash' => 
    array (
      'alias' => 'content_hash',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'content_hash' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
);
