<?php

namespace Support;

class Module {

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
                //Fetch
                'Model' => 'Support\Fetch\Model',
                'Form' => 'Support\Fetch\Form',
                //General
                'AuthService' => 'Support\General\Authentication',
            ),
        );
    }

}