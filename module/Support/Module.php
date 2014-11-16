<?php

namespace Support;

use Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module implements FormElementProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/',
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                //Factory
                'TableGatewayFactory' => 'Support\Factory\TableGatewayFactory',
                'ModelFactory' => 'Support\Factory\Model',
                'FormFactory' => 'Support\Factory\Form',
                //General
                'AuthService' => 'Support\General\Authentication',
            ),
        );
    }

    public function getFormElementConfig() {
        return array(
            'invokables' => array(
               // 'UsersFieldset' => 'Support\Form\UsersFieldset'
            )
        );
    }

}