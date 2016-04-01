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
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class Module {

    public function initSession(array $config) {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }

    public function onBootstrap(MvcEvent $e) {
        $application = $e->getApplication();

        $this->initSession(array(
            'remember_me_seconds' => 180,
            'use_cookies' => true,
            'cookie_httponly' => true,
        ));

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $application->getServiceManager();
        $environment = $serviceManager->get('Twig_Environment');
        /** @var \ZfcTwig\moduleOptions $options */
        $options = $serviceManager->get('ZfcTwig\ModuleOptions');

        foreach ($options->getExtensions() as $extension) {
            // Allows modules to override/remove extensions.
            if (empty($extension)) {
                continue;
            } else if (is_string($extension)) {
                if ($serviceManager->has($extension)) {
                    $extension = $serviceManager->get($extension);
                } else {
                    $extension = new $extension();
                }
            } elseif (!is_object($extension)) {
                throw new InvalidArgumentException('Extensions should be a string or object.');
            }
            $environment->addExtension($extension);
        }
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'GlobalConfig' => function($sm) {
                    return new Config(include __DIR__ . '/../../config/autoload/global.php');
                },
                'DbAdapter' => function($sm) {
                    $config = $sm->get('GlobalConfig');

                    $dbAdapter = new DbAdapter(array(
                        'driver' => $config->db->get('driver'),
                        'username' => $config->db->get('username'),
                        'password' => $config->db->get('password'),
                        'hostname' => $config->db->get('hostname'),
                        'database' => $config->db->get('database')
                    ));

                    return $dbAdapter;
                },
                'LoginService' => function($sm) {
                    $db = $sm->get('DbAdapter');

                    $authConfig = $this->getConfig()['auth'];
                    $authAdapter = new AuthAdapter($db, $authConfig['user_table'], $authConfig['identity_column'], $authConfig['credential_column'], $authConfig['additionals']);

                    return $authAdapter;
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
        