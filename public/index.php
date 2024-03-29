<?php

use Core\Request\Request;
use Core\Router\Router;

date_default_timezone_set("America/Lima");
session_start();

/*
 |-----------------------------------------------------
 | Obtener los requerimientos de composer (Clases)
 |-----------------------------------------------------
 | En vendor/autoload.php estan los requerimientos 
 | ejm: app/controllers/*.php
 |      app/models/*.php
 |      core/database/*.php
 |
 */
require '../vendor/autoload.php';




/*
 |-----------------------------------------------------
 | Obtener Bootstrap (Principal)
 |-----------------------------------------------------
 | Son los requerimientos del sitema
 |
 */
require '../bootstrap/bootstrap.php';




/*
 |-----------------------------------------------------
 | Obtener la Rutas
 |-----------------------------------------------------
 | Cada vez que el usuario ingrese una uri en la url
 | se cargara las rutas de app/routes.php e identifica_
 | ra cual es su controller y su acction
 |
 */

Router::load(dirname(__DIR__) . '/router/web.php')
    ->direct(Request::uri(), Request::method());