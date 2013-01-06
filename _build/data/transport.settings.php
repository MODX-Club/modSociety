<?php

/*
 * @package modxRepository
 * @subpackage build
 * @author Fi1osof
 * http://community.modx-cms.ru/profile/Fi1osof/
 * http://modxstore.ru
 */
global  $modx, $sources;
$settings = array();

$settings['modblog.assets_url'] = $modx->newObject('modSystemSetting');
$settings['modblog.assets_url']->fromArray(array(
    'key' => 'modblog.assets_url',
    'value' => '{assets_url}components/modblog/',
    'xtype' => 'textfield',
    'namespace' => NAMESPACE_NAME,
    'area' => 'site',
),'',true,true);


 
return $settings;