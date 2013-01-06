<?php


$pkgName = 'modSociety';

$pkgLowerName = strtolower($pkgName);

if ($object->xpdo) {
    $modx =& $object->xpdo;
   
    switch ($options[xPDOTransport::PACKAGE_ACTION]) { 
        case xPDOTransport::ACTION_UNINSTALL:
            if ($modx instanceof modX) {
                
                // Update users
                if($users = $modx->getCollection('modUser', array(
                    'class_key' => 'SocietyUser'
                ))){
                    foreach($users as &$user){
                        $user->set('class_key', 'modUser');
                        $user->save();
                    }
                }
                
                $modx->removeExtensionPackage($pkgName);
                
            }
            break;
    }
}
return true;