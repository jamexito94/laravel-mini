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
    'name' => 'tarea1',

    'username' => 'root',

    'password' => '',

    'connection' => 'mysql:host=127.0.0.1',
    
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];