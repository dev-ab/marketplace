<?php

namespace Support\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\ServiceManager\ServiceLocatorInterface;

class TableGatewayFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return $serviceLocator;
    }

    public function generateTableGateway($tablename, $entity, $adapter = null) {
        if (!$adapter) {
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        } else {
            $dbAdapter = $this->getServiceLocator()->get($adapter);
        }

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($entity);
        return new TableGateway($tablename, $dbAdapter, null, $resultSetPrototype);
    }

}
