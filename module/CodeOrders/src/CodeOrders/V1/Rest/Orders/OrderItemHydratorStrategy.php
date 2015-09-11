<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 10/09/2015
 * Time: 22:11
 */

namespace CodeOrders\V1\Rest\Orders;


use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class OrderItemHydratorStrategy implements StrategyInterface
{
    private $hydrator;

    /**
     * OrderItemHydratorStrategy constructor.
     */
    public function __construct(ClassMethods $hydrator)
    {
        $this->hydrator = $hydrator;
    }


    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param mixed $value The original value.
     * @param object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($items)
    {
        $data = [];

        foreach ($items as $item) {
            $data[] = $this->hydrator->extract($item);
        }

        return $data;
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param mixed $value The original value.
     * @param array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     */
    public function hydrate($value)
    {
        throw new \RuntimeException('Not');
    }
}