<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 08/10/2015
 * Time: 23:18
 */

namespace CodeOrders\V1\Rest\Clients;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class ClientsRepositoryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('CodeOrders\\V1\\Rest\\Clients\\ClientsTableGateway');

        $clientsRepository = new ClientsRepository($tableGateway);

        return $clientsRepository;
    }

}