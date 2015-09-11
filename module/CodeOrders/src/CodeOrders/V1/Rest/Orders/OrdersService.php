<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 10/09/2015
 * Time: 22:30
 */

namespace CodeOrders\V1\Rest\Orders;


class OrdersService
{
    private $repository;

    /**
     * OrdersService constructor.
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function insert($data)
    {
        $order = $this->repository->insert($data);

        return $order;
    }


}