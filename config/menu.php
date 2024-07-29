<?php

/***********************************************************
 * controller | string         | required |                *
 * action     | string         | optional | default: index *
 * text       | string         | required |                *
 * title      | string         | optional | default: false *
 * class      | string         | optional | default: false *
 * position   | int            | optional |                *
 * plugin     | bool           | optional | default: false *
 * prefix     | bool           | optional | default: false *
 * access     | array<string>  | required |                *
 ***********************************************************/

return [
    'Menu' => [
        [
            'controller' => 'Dashboard',
            'text' => __x('menu', 'Dashboard'),
            'access' => ['*'],
        ],
        [
            'controller' => 'Users',
            'text' => __x('menu', 'Users'),
            'access' => ['admin'],
        ],
    ],
];
