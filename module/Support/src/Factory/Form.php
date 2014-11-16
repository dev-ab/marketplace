<?php

namespace Support\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Form implements FactoryInterface {

    protected $tables = array();
    protected $ServiceLocator;

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
        return $this;
    }

    public function getForm($formName, $filter = true) {
        $formObject = "Support\\Form\\" . $formName . 'Form';
        $formManager = $this->ServiceLocator->get('FormElementManager');
        $formInstance = $formManager->get($formObject);
        $formInstance->prepareElements();
        return $formInstance;
    }

}
