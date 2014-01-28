<?php


$pkgName = 'modSociety';

$pkgLowerName = strtolower($pkgName);

if ($object->xpdo) {
    $modx =& $object->xpdo;
   
    switch ($options[xPDOTransport::PACKAGE_ACTION]) { 
        case xPDOTransport::ACTION_UNINSTALL:
            if ($modx instanceof modX) {
                
                $modx->removeExtensionPackage($pkgName);
                
            }
            break;
    }
}
return true;