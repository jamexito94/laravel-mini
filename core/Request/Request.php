<?php

namespace App\Core\Request;

class Request
{
    /**
     * Obtiene la uri de la pagina web
     * @return string uri
     */
    public static function uri()
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );
    }
    /**
     * Obtiene el metodo de la pagina web (GET | POST)
     * @return string metodo
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}