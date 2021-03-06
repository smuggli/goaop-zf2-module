<?php
/*
 * Go! AOP framework
 *
 * @copyright Copyright 2016, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\ZF2\GoAopModule;

use Go\Core\AspectContainer;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * ZF2 Module for registration of Go! AOP Framework
 */
class Module implements ConfigProviderInterface, BootstrapListenerInterface
{

    /**
     * Listen to the bootstrap event
     *
     * @param MvcEvent|EventInterface $e
     *
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();

        /** @var AspectContainer $aspectContainer */
        $aspectContainer = $serviceManager->get(AspectContainer::class);
        $config          = $serviceManager->get('config');
        $listOfAspects   = $config['goaop_aspect'];
        foreach ($listOfAspects as $aspectService) {
            $aspect = $serviceManager->get($aspectService);
            $aspectContainer->registerAspect($aspect);
        }
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
