<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 10/09/2015
 * Time: 21:09
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class OrdersRepositoryFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('DbAdapter');

        $hydrator = new HydratingResultSet(new ClassMethods(), new OrdersEntity());

        $tableGateway = new TableGateway('orders', $dbAdapter, null, $hydrator);

        $tableGatewayItem = $serviceLocator->get('CodeOrders\\V1\\Rest\\Orders\\OrderItemRepository');

        $tableGatewayClient = $serviceLocator->get('CodeOrders\\V1\\Rest\\Clients\\ClientsTableGateway');

        $ordersRepository = new OrdersRepository($tableGateway, $tableGatewayItem, $tableGatewayClient);

        return $ordersRepository;
    }
}