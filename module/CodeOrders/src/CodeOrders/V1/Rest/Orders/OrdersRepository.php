<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 10/09/2015
 * Time: 21:07
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\ObjectProperty;

class OrdersRepository
{

    private $tableGateway;
    private $tableGatewayItem;
    private $tableGatewayClient;

    /**
     * UsersRepository constructor.
     */
    public function __construct(TableGatewayInterface $tableGateway, TableGatewayInterface $tableGatewayItem, TableGatewayInterface $tableGatewayClient)
    {
        $this->tableGateway = $tableGateway;
        $this->tableGatewayItem = $tableGatewayItem;
        $this->tableGatewayClient = $tableGatewayClient;
    }

    public function findAll()
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('items', new OrderItemHydratorStrategy(new ClassMethods()));
        $orders = $this->tableGateway->select([]);
        $res = [];

        foreach ($orders as $order) {
            $items = $this->tableGatewayItem->select(['order_id' => $order->getId()]);

            foreach ($items as $item) {
                $order->addItem($item);
            }

            $data = $hydrator->extract($order);
            $res[] = $data;
        }

        $arrayAdapter = new ArrayAdapter($res);
        $ordersCollection = new OrdersCollection($arrayAdapter);

        return $ordersCollection;
    }

    public function find($id)
    {
        $resultSet = $this->tableGateway->select(['id' => (int)$id]);

        if ($resultSet->count() == 1) {
            $hydrator = new ClassMethods();
            $hydrator->addStrategy('items', new OrderItemHydratorStrategy(new ClassMethods()));

            $order = $resultSet->current();

            $client = $this->tableGatewayClient->select(['id' => $order->getClientId()])->current();

            $sql = $this->tableGatewayItem->getSql();

            $select = $sql->select();
            $select->join(
                'products',
                'order_items.product_id = products.id',
                ['product_name' => 'name']
            )->where(['order_id' => $order->getId()]);

            $items = $this->tableGatewayItem->selectWith($select);

            $order->setClient($client);

            foreach ($items as $item) {
                $order->addItem($item);
            }

            $data = $hydrator->extract($order);

            return $data;
        }

        return false;
    }

    public function insert($data)
    {
        $this->tableGateway->insert($data);

        $id = $this->tableGateway->getLastInsertValue();

        return $id;
    }

    public function update(array $data, $id)
    {
        $resultSet = $this->tableGateway->update($data,['id' => (int)$id]);

        return $resultSet;
    }

    public function delete($id)
    {
        $resultSet = $this->tableGateway->delete(['id' => (int)$id]);

        return $resultSet;

    }

    public function insertItem($data)
    {
        $this->tableGatewayItem->insert($data);

        $id = $this->tableGatewayItem->getLastInsertValue();

        return $id;
    }

    public function deleteItem($id)
    {
        $resultSet = $this->tableGatewayItem->delete(['order_id' => (int)$id]);

        return $resultSet;

    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

}