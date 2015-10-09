<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 08/10/2015
 * Time: 23:16
 */

namespace CodeOrders\V1\Rest\Clients;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Form\Annotation\Hydrator;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Stdlib\Hydrator\ObjectProperty;

class ClientsRepository
{

    private $tableGateway;

    /**
     * UsersRepository constructor.
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function findAll()
    {
        $paginatorAdapter = new DbTableGateway($this->tableGateway);

        return new ClientsCollection($paginatorAdapter);
    }

    public function find($id)
    {
        $resultSet = $this->tableGateway->select(['id' => (int)$id]);

        return $resultSet->current();
    }

    public function update($id,  $data)
    {
        $hydrator = new ObjectProperty();
        $data = $hydrator->extract($data);

        $resultSet = $this->tableGateway->update($data,['id' => (int)$id]);

        return $resultSet;

    }

    public function insert($data)
    {
        $hydrator = new ObjectProperty();
        $data = $hydrator->extract($data);

        $resultSet = $this->tableGateway->insert($data);

        return $resultSet;

    }

    public function delete($id)
    {
        $resultSet = $this->tableGateway->delete(['id' => (int)$id]);

        return $resultSet;

    }

}