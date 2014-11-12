<?php

namespace Support\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class Form implements FactoryInterface {

    protected $tables = array();
    protected $ServiceLocator;

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
        return $this;
    }

    public function getForm($formName, $filter = true) {
        $formObject = "Support\\Form\\" . $formName . 'Form';
        $filterObject = "Support\\Form\\" . $formName . 'Filter';

        $formInstance = new $formObject();
        if ($formInstance instanceof ServiceLocatorAwareInterface)
            $formInstance->setServiceLocator($this->ServiceLocator);
        $formInstance->prepareElements();

        if ($filter)
            $formInstance->setInputFilter(new $filterObject());

        return $formInstance;
    }

}
