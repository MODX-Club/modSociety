<?php
$xpdo_meta_map['SocietyBlog']= array (
  'package' => 'modSociety',
  'version' => '1.1',
  'extends' => 'modResource',
  'fields' => 
    array (
        // 'show_in_tree' => 0,
        'class_key' => 'SocietyBlog',
    ),
  'fieldMeta' => 
    array (),
  'composites' => 
  array (
    'Attributes' => 
    array (
      'class' => 'SocietyBlogAttributes',
      'local' => 'id',
      'foreign' => 'resourceid',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
    'BlogTopics' => 
    array (
      'class' => 'SocietyBlogTopic',
      'local' => 'id',
      'foreign' => 'blogid',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
