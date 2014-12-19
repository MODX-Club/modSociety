<?php
$xpdo_meta_map['SocietyTopicTags']= array (
  'package' => 'modSociety',
  'version' => '2.0.3',
  'table' => 'society_topic_tags',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'topic_id' => NULL,
    'tag' => NULL,
    'active' => NULL,
  ),
  'fieldMeta' => 
  array (
    'topic_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
    ),
    'tag' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => false,
    ),
  ),
);
