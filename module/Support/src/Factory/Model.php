<?php

namespace Support\Factory;

use Zend\ServiceManager\FactoryInterface;
use Support\Factory\TableGatewayFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class Model implements FactoryInterface {

    protected $tables = array();
    protected $ServiceLocator;

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
        return $this;
    }

    public function getTable($tablename, $adapter = null) {
        if (isset($this->tables[$tablename]))
            return $this->tables[$tablename];
        $entity_name = "Support\\Entity\\" . $this->getEntityName($tablename);
        $entity = new $entity_name();

        $tableGatewayFactory = $this->ServiceLocator->get('TableGatewayFactory');
        $tableGatewayFactory->setTablename($tablename);
        $tableGatewayFactory->setEntity($entity);
        $tableGatewayFactory->setAdapter($adapter);
        $tableGateway = $tableGatewayFactory->generateTableGateway();
        $table_model = "Support\\Table\\" . $this->getEntityName($tablename) . 'Table';
        return new $table_model($tableGateway);
    }

    public function getEntityName($tablename) {
        $pieces = explode('_', $tablename);
        return join('', array_map(function($val) {
                                    return ucwords($val);
                                }, $pieces));
    }

}
