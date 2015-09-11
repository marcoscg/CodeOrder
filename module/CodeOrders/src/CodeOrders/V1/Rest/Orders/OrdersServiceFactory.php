<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 10/09/2015
 * Time: 22:31
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OrdersServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $orderRepository = $serviceLocator->get('CodeOrders\\V1\\Rest\\Orders\\OrdersRepository');

        return new OrdersService($orderRepository);
    }
}