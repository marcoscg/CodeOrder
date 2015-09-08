<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 07/09/2015
 * Time: 19:50
 */

namespace CodeOrders\V1\Rest\Users;


use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class UsersRepositoryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('DbAdapter');
        //$userMapper = new UsersMapper();
        //$hydrator = new HydratingResultSet($userMapper, new UsersEntity());

        $hydrator = new HydratingResultSet(new ClassMethods(), new UsersEntity());

        $tableGateway = new TableGateway('oauth_users', $dbAdapter, null, $hydrator);

        $usersRepository = new UsersRepository($tableGateway);

        return $usersRepository;
    }


}