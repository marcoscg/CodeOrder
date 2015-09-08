<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 07/09/2015
 * Time: 19:41
 */

namespace CodeOrders\V1\Rest\Products;


use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbTableGateway;

class ProductsRepository
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

        return new ProductsCollection($paginatorAdapter);
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

    public function delete($id)
    {
        $resultSet = $this->tableGateway->delete(['id' => (int)$id]);

        return $resultSet;

    }
}