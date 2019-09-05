<?php

use Core\Aplication\App;
use Core\Database\Connection;
use Core\Database\QueryBuilder;

/*
 |-----------------------------------------------------------
 | Parametros de configuracion
 |-----------------------------------------------------------
 |
 |
 | Añadimos a App la configuracion como parametro config y sus
 | recursos en el archivo config.php
 */
App::bind('config', require dirname(__DIR__) . '/config/config.php');




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



