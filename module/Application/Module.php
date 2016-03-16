<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);

        if ($matchedRoute) {
            $params = $matchedRoute->getParams();

            $controller = $params['controller'];
            $action = $params['action'];

            $module_array = explode('\\', $controller);
            $module = array_pop($module_array);

            $route = $matchedRoute->getMatchedRouteName();

            $e->getViewModel()->setVariables(
                array(
                    'CURRENT_MODULE_NAME' => $module,
                    'CURRENT_CONTROLLER_NAME' => $controller,
                    'CURRENT_ACTION_NAME' => $action,
                    'CURRENT_ROUTE_NAME' => $route,
                )
            );
        }

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
