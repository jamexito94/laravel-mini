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
App::bind('config_app', require dirname(__DIR__) . '/config/app.php');

App::bind('config_database', require dirname(__DIR__) . '/config/database.php');




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

    Connection::make(App::get('config_database'))

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



