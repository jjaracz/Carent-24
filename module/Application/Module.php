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
use Zend\Db\Adapter\Adapter as DbAdapter;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'GlobalConfig' => function($sm) {
                    return new Config(include __DIR__ . '/../../config/autoload/global.php');
                },
                'DbAdapter' => function($sm){
                    $config = $sm->get('GlobalConfig');

                    $dbAdapter = new DbAdapter(array(
                        'driver' => $config->db->get('driver'),
                        'username' => $config->db->get('username'),
                        'password' => $config->db->get('password'),
                        'hostname' => $config->db->get('hostname'),
                        'database' => $config->db->get('database')
                    ));

                    return $dbAdapter;
                }
            )
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
