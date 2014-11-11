<?php

namespace Support\Fetch;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Form implements FactoryInterface {

    protected $tables = array();
    protected $ServiceLocator;

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
        return $this;
    }

    public function getForm($formName) {
        $formObject = "Support\\Form\\" . $formName . 'Form';
        $filterObject = "Support\\Form\\" . $formName . 'Filter';

        $formInstance = new $formObject();
        $formInstance->setInputFilter(new $filterObject());

        return $formInstance;
    }

}
