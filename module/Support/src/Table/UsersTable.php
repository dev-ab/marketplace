<?php

namespace Support\Table;

use Zend\Db\TableGateway\TableGatewayInterface;

class UsersTable {

    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        if (!$this->tableGateway)
            $this->tableGateway = $tableGateway;
    }

}

