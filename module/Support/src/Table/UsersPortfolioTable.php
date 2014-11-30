<?php

namespace Support\Table;

use Zend\Db\TableGateway\TableGatewayInterface;

class UsersPortfolioTable {

    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getPortfolio($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getPortfolioByUser($userId) {
        $id = (int) $userId;
        $rowset = $this->tableGateway->select(array('user_id' => $userId));
        $rows = $rowset->toArray();
        return $rows;
    }

    public function savePortfolio($data) {
        $id = (int) $data['id'];
        if ($id == 0) {
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getCountry($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

}

