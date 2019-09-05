<?php

use App\Core\Aplication\App;
// use App\Controllers\AuthController;
// use App\Controllers\ProfileController;

/*
 |-----------------------------------------------------------
 | Parametros de configuracion
 |-----------------------------------------------------------
 |
 |
 | Añadimos a App la configuracion como parametro config y sus
 | recursos en el archivo config.php
 */
App::bind('config', require '../config/config.php');




/*
 |-----------------------------------------------------------
 | Connecion a la base de datos
 |-----------------------------------------------------------
 |
 |
 | Añadimos a App la configuracion como parmetro database y su
 | recurso la conccion a la base de datos
 */
App::bind('database', new QueryBuilder(

    Connection::make(App::get('config')['database'])

));


/*
 |-----------------------------------------------------------
 | Helpers
 |-----------------------------------------------------------
 |
 |
 | Funciones de ayuda
 */

require dirname(__DIR__) . "/core/Helpers.php";



