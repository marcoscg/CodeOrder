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

    /**
     * UsersRepository constructor.
     */
    public function __construct(TableGatewayInterface $tableGateway, TableGatewayInterface $tableGatewayItem)
    {
        $this->tableGateway = $tableGateway;
        $this->tableGatewayItem = $tableGatewayItem;
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

        return $resultSet->current();
    }

    public function insert($data)
    {
        $hydrator = new ObjectProperty();
        $data = $hydrator->extract($data);

        try {

            $this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $orderData = $data;
            unset($orderData['item']);
            $items = $data['item'];

            $this->tableGateway->insert($orderData);
            $id = $this->tableGateway->getLastInsertValue();

            foreach ($items as $item) {
                $item['order_id'] = $id;
                $this->insertItem($item);
            }

            $this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();

        } catch (\Exception $e) {
            $this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }

        return $id;
    }

    public function insertItem($data)
    {
        $this->tableGatewayItem->insert($data);
    }

}