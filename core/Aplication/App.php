<?php

namespace Core\Aplication;

class App{

    protected static $parameters = [];

    /**
     * Guardar configuracion con parametro y valores
     * 
     * @param string $key Llave de configuracion
     * @param string $value Valores a devolver
     * 
     */
    public static function bind($key, $value){

        static::$parameters[$key] = $value;

    }

    /**
     * Obtener el valor la configuracion mediante la
     * palabra clave
     * 
     * @param string $key Llave de configuracion
     */
    public static function get($key){

        if (! array_key_exists($key, static::$parameters)) {

            throw new Exception("Error la clave {$key} no existe");
            
        }

        return static::$parameters[$key];

    }

}