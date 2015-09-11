<?php
namespace CodeOrders\V1\Rest\Orders;

class OrdersResourceFactory
{
    public function __invoke($services)
    {
        return new OrdersResource($services->get('CodeOrders\\V1\\Rest\\Orders\\OrdersRepository'));
    }
}
