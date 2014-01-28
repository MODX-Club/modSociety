<?php
$xpdo_meta_map['SocietySubscribers']= array (
  'package' => 'modSociety',
  'version' => '1.1',
  'table' => 'society_subscribers',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'userid' => NULL,
    'subscriberid' => NULL,
    'rank' => 0,
  ),
'fieldMeta' => 
  array (
    'userid' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
    ),
    'subscriberid' => 
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
    'userid' => 
    array (
      'alias' => 'userid',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'userid' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'subscriberid' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
