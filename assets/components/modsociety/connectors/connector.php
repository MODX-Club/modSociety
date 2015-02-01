<?php
// ini_set('display_errors', true);
$_REQUEST['ctx'] = 'web';
    
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$_SERVER['HTTP_MODAUTH']= $modx->user->getUserToken($modx->context->get('key'));
 
$location = '';

/* handle request */
$path = MODX_CORE_PATH . 'components/modsociety/';
$path .= 'processors/';

$action = 'society/web/public/action';

$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => $location,
    'action' => $action,
));