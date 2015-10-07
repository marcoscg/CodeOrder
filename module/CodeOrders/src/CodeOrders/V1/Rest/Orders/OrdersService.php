<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 10/09/2015
 * Time: 22:30
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Stdlib\Hydrator\ClassMethods;

class OrdersService
{
    private $repository;

    /**
     * OrdersService constructor.
     * @param $repository
     */
    public function __construct(OrdersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function insert($data)
    {
        $hydrator = new ObjectProperty();
        $data = $hydrator->extract($data);

        $orderData = $data;
        unset($orderData['item']);
        $items = $data['item'];

        $tableGateway = $this->repository->getTableGateway();

        try {

            $tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $orderId = $this->repository->insert($orderData);

            foreach ($items as $item) {
                $item['order_id'] = $orderId;
                $this->repository->insertItem($item);
            }

            $tableGateway->getAdapter()->getDriver()->getConnection()->commit();

        } catch (\Exception $e) {
            $tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }

        return $orderId;

    }

    public function update($id,  $data)
    {

        $hydrator = new ObjectProperty();
        $data = $hydrator->extract($data);

        $orderData = $data;
        unset($orderData['item']);
        $items = $data['item'];

        $tableGateway = $this->repository->getTableGateway();

        try {

            $tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $this->repository->update($id, $orderData);

            $this->repository->deleteItem($id);

            foreach ($items as $item) {
                $item['id'] = 0;
                $item['order_id'] = $id;
                $this->repository->insertItem($item);
            }

            $tableGateway->getAdapter()->getDriver()->getConnection()->commit();

        } catch (\Exception $e) {
            $tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }

        return $id;

    }

    public function delete($id)
    {
        $tableGateway = $this->repository->getTableGateway();

        try {

            $tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $this->repository->delete($id);

            $this->repository->deleteItem($id);

            $tableGateway->getAdapter()->getDriver()->getConnection()->commit();

            return 'success';

        } catch (\Exception $e) {
            $tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            return 'error';
        }

    }


}