<?php

// This is a examples for using routings

$routes = [
        '/'                 => [
                'http'  => 'GET',
                'action'=> function ($utils){ 

                }
        ],
        '/categoria/?'      => [
                'http'  => 'GET',
                'action'=> function ($slug, $res){ 

                 }
        ],
        '/cart'             => [
                'http'  => 'GET',
                'action'=> '@models/test/index'
        ],
        '/confirmation'     => [
                'http'  => 'POST',
                'action'=> '@models/test/api'
        ]          
];