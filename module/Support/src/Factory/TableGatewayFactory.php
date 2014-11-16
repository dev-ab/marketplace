<?php

namespace Support\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\ServiceManager\ServiceLocatorInterface;

class TableGatewayFactory implements FactoryInterface {

    protected $Tablename;
    protected $Entity;
    protected $Adapter;
    protected $DbAdapter;
    protected $ServiceLocator;

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
        return $this;
    }

    public function generateTableGateway() {
        if (!$this->Adapter) {
            $this->DbAdapter = $this->ServiceLocator->get('Zend\Db\Adapter\Adapter');
        } else {
            $this->DbAdapter = $this->ServiceLocator->get($this->Adapter);
        }

        if (!$this->Tablename || !$this->Entity) {
            return false;
        }
        $resultSetPrototype = new HydratingResultSet();
        $resultSetPrototype->setHydrator(new ClassMethods());
        $resultSetPrototype->setObjectPrototype($this->Entity);

        return new TableGateway($this->Tablename, $this->DbAdapter, null, $resultSetPrototype);
    }

    public function setTablename($tablename) {
        $this->Tablename = $tablename;
    }

    public function setEntity($entity) {
        $this->Entity = $entity;
    }

    public function setAdapter($adapter) {
        $this->Adapter = $adapter;
    }

}
