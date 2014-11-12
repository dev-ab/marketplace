<?php

namespace Support\Table;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Stdlib\Hydrator\ArraySerializable;
use Support\Entity\Users;

class UsersTable {

    protected $tableGateway;
    protected $hydrator;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
        $this->hydrator = new ArraySerializable();
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveUser(Users $user) {
        $data = $this->hydrator->extract($user);
        print_r($data);
        return
        $id = (int) $data['id'];
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function prepareData($data) {
        $preparedData = array();
        $preparedData['id'] = $data['id'];
        $preparedData[] = $data['id'];
        $preparedData[] = $data['id'];
        $preparedData[] = $data['id'];
        $preparedData[] = $data['id'];



        return $preparedData;
    }

}
