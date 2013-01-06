<?php
switch($modx->event->name) {
    case 'OnManagerPageInit':
        $cssFile = $modx->getOption('modsociety.manager_assets_url',null,$modx->getOption('manager_url').'components/modsociety/assets/mgr/').'css/modsociety.css';
        $modx->regClientCSS($cssFile);
    break;
}