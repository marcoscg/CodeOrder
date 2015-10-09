<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 09/10/2015
 * Time: 00:07
 */

namespace CodeOrders\V1\Rest\Clients;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class ClientsTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('DbAdapter');

        $hydrator = new HydratingResultSet(new ClassMethods(), new ClientsEntity());

        $tableGateway = new TableGateway('clients', $dbAdapter, null, $hydrator);

        return $tableGateway;
    }

}