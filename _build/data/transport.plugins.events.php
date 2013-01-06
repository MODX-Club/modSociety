<?php
/**
 * @package bannery
 * @subpackage build
 */
$events = array();

$events['OnManagerPageInit']= $modx->newObject('modPluginEvent');
$events['OnManagerPageInit']->fromArray(array(
    'event' => 'OnManagerPageInit',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

return $events;