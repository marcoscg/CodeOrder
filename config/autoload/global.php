<?php
return array(
    'db' => array(
        'adapters' => array(
            'DbAdapter' => array(),
        ),
    ),
    'router' => array(
        'routes' => array(
            'oauth' => array(
                'options' => array(
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ),
                'type' => 'regex',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'CodeOrders\\V1' => 'oauthadapter',
            ),
        ),
    ),
    'zf-content-negotiation' => array(
        'selectors' => array(
            'HalJson' => array(
                'ZF\\Hal\\View\\HalJsonModel' => array(
                    0 => 'application/json',
                    1 => 'application/*+json',
                    2 => 'multipart/form-data',
                ),
            ),
            'Json' => array(
                'ZF\\ContentNegotiation\\JsonModel' => array(
                    0 => 'application/json',
                    1 => 'application/*+json',
                    2 => 'multipart/form-data',
                ),
            ),
        ),
    ),
);
