<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 07/09/2015
 * Time: 19:50
 */

namespace CodeOrders\V1\Rest\Products;


use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ProductsRepositoryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('DbAdapter');

        $hydrator = new HydratingResultSet(new ClassMethods(), new ProductsEntity());

        $tableGateway = new TableGateway('products', $dbAdapter, null, $hydrator);

        $productsRepository = new ProductsRepository($tableGateway);

        return $productsRepository;
    }


}