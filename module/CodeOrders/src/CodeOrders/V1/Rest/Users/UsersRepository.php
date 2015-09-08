<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 07/09/2015
 * Time: 19:41
 */

namespace CodeOrders\V1\Rest\Users;


use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbTableGateway;

class UsersRepository
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
        $tableGatewary = $this->tableGateway;
        $paginatorAdapter = new DbTableGateway($tableGatewary);

        return new UsersCollection($paginatorAdapter);
    }

    public function find($id)
    {
        $resultSet = $this->tableGateway->select(['id' => (int)$id]);

        return $resultSet->current();
    }

    public function update($id, $data)
    {
        $resultSet = $this->tableGateway->update($data,['id' => (int)$id]);

        return $resultSet->current();

    }

    public function insert($data)
    {
        $resultSet = $this->tableGateway->insert($data);

        return $resultSet->current();

    }
}