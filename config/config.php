<?php

return [
    /*
    |--------------------------------------------------
    | Configuracion de la base de datos
    |--------------------------------------------------
    | En esta seccion puedes cambiar los parametros de 
    | tu connecion de tu base de datos
    |
    | */
    'database' => [
        'name' => 'tarea1',
        'username' => 'root',
        'password' => '',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],

    'host'  => [
        'protocolo' => 'http://',
        'dominio' => $_SERVER['HTTP_HOST']
    ],

    'mySite' => [
        'name' => 'Llanavilla',
        'descripcion' => '',
        'img-sin-datos' => 'assets/img/illustrations/lost.svg',
        'img-logo' => 'assets/img/logo.svg'
    ]
];
