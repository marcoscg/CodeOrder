<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 10/09/2015
 * Time: 22:30
 */

namespace CodeOrders\V1\Rest\Orders;


use CodeOrders\V1\Rest\Products\ProductsRepository;
use CodeOrders\V1\Rest\Users\UsersRepository;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Stdlib\Hydrator\ClassMethods;

class OrdersService
{
    private $repository;
    private $usersRepository;
    private $productsRepository;

    /**
     * OrdersService constructor.
     * @param $repository
     */
    public function __construct(OrdersRepository $repository, UsersRepository $usersRepository, ProductsRepository $productsRepository )
    {
        $this->repository = $repository;
        $this->usersRepository = $usersRepository;
        $this->productsRepository = $productsRepository;
    }

    public function insert($data)
    {
        $hydrator = new ObjectProperty();

        $data->user_id = 4;// $this->usersRepository->getAuthenticated()->getId();
        $data->created_at = (new \DateTime())->format('Y-m-d');
        $data->total = 0;
        $items = $data->item;

        $orderData = $hydrator->extract($data);
        unset($orderData['item']);

        $tableGateway = $this->repository->getTableGateway();

        try {

            $tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $orderId = $this->repository->insert($orderData);

            $total = 0;
            foreach ($items as $item) {
                $product = $this->productsRepository->find($item['product_id']);
                $item['order_id'] = $orderId;
                $item['price'] = $product->getPrice();
                $item['total'] = $item['quantity'] * $item['price'];
                $total += $item['total'];
                $this->repository->insertItem($item);
            }

            $this->repository->update(['total'=>$total],$orderId);

            $tableGateway->getAdapter()->getDriver()->getConnection()->commit();

            return ['order_id' => $orderId];

        } catch (\Exception $e) {
            $tableGateway->getAdapter()->getDriver()->getConnection()->rollback();

            var_dump($e->getMessage()); die;

            return 'error';
        }

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