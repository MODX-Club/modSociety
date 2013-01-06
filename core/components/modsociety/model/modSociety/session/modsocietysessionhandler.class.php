<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MODX_CORE_PATH.'model/modx/modsessionhandler.class.php';

class  modSocietySessionHandler extends modSessionHandler{
    function __construct(modX &$modx) {
        parent::__construct($modx);
        // session_start();
        
        
    } 
}
?>
