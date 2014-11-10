<?php

namespace Support\Fetch;

use Support\Factory\TableGatewayFactory;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Model implements ServiceLocatorAwareInterface {

    protected $tables = array();

    public function getTable($tablename, $adapter = null) {
        if ($this->tables[$tablename])
            return $this->tables[$tablename];
        $entity_name = "Support\\Entity\\" . ucwords($tablename);

        $entity = new $entity_name();

        $tableGatewayFactory = new TableGatewayFactory();
        $tableGateway = $tableGatewayFactory->createService($tablename, $entity, $adapter);
        $table_name = "Support\\Table\\" . ucwords($tablename) . 'Table';
        return new $table_name($tableGateway);
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
    }

    public function getServiceLocator() {
        return $this->ServiceLocator;
    }

}
