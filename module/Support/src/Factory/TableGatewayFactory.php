<?php

namespace Support\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class TableGatewayFactory implements FactoryInterface {

    /**
     * {@inheritDoc}
     */
    public function createService($tablename, $entity, $adapter = null) {
        if (!$adapter)
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        else
            $dbAdapter = $sm->get($adapter);

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($entity);
        return new TableGateway($tablename, $dbAdapter, null, $resultSetPrototype);
    }

}