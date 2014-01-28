<?php

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('modsociety.core_path',null,$modx->getOption('core_path').'components/modsociety/').'model/';
            $modx->addPackage('modSociety', $modelPath);

            $manager = $modx->getManager();
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
            $manager->createObjectContainer('SocietyTopicAttributes');
            $manager->createObjectContainer('SocietyBlogAttributes');
            $manager->createObjectContainer('SocietyBlogTopic');
            $manager->createObjectContainer('SocietyComment');
            $manager->createObjectContainer('SocietySubscribers');
            $manager->createObjectContainer('SocietyThread');
            $manager->createObjectContainer('SocietyVote');
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;
    }
}
return true;