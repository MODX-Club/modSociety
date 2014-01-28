<?php
switch($modx->event->name) {
    
    case 'OnHandleRequest':
        //return;
        if($modx->context->key == 'mgr'){
            return;
        }
        
        // Add Smarty templates directory.
        // modxSmarty extra required
        if(
            $modx->getOption('modsociety.enable_smarty_template')
        ){
            $tpl = $modx->getOption('modsociety.smarty_template', null, 'default');
            $modx->smarty->addTemplateDir(MODX_CORE_PATH. "components/modsociety/templates/web/{$tpl}/");
        }
        
        if(!empty($_REQUEST['society_action'])){
            
            $error = '';
            $success = '';   
              
            if($response = $modx->runProcessor($processor, $_REQUEST, array(
                'processors_path' => $modx->getObject('modNamespace', $namespace) -> getCorePath() .'processors/',    
            ))){
                if($response->isError()){
                    $error = $response->getMessage();
                    $modx->log(xPDO::LOG_LEVEL_ERROR, $error);
                    $modx->log(xPDO::LOG_LEVEL_ERROR, print_r($response->getAllErrors(), true));
                }
                else{
                    $success = $response->getMessage();
                }
            }
            else{
                $error = 'Не удалось выполнить процессор';
            }
            $modx->setPlaceholder('modsociety.action.success', $success);
            $modx->setPlaceholder('modsociety.action.failure', $error);
            
            
            return;
        }        
         
        break;
    
    
    case 'OnManagerPageInit':
        $cssFile = $modx->getOption('modsociety.manager_assets_url',null,$modx->getOption('manager_url').'components/modsociety/assets/mgr/').'css/modsociety.css';
        $modx->regClientCSS($cssFile);
    break;
}