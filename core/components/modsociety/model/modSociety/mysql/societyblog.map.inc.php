<?php
$xpdo_meta_map['SocietyBlog']= array (
  'package' => 'modx',
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
      'foreign' => 'resource_id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
