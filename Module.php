<?php
//namespace ThirdPartyConnect;
namespace SocialConnect;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return
            (include __DIR__ . '/config/services.config.php') +
            (include __DIR__ . '/config/controllers.config.php') +
            (include __DIR__ . '/config/routes.config.php');
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
