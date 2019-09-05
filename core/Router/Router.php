<?php

namespace App\Core\Router;

class Router
{
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Carga todas las rutas al sistema
     * @param array $file 
     */
    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    /**
     * Establecer la ruta de acceso con el controlador y funcion en el
     * metodo GET
     * @param string $uri la url 
     * @param string $controller el controlador ejm: Micontroller@action
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Establecer la ruta de acceso con el controlador y funcion en el
     * metodo POST
     * @param string $uri la url
     * @param string $controller el controlador ejm: Micontroller@action
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Redireccionar al controlador especificado en la uri
     * @param string $uri la uri
     * @param string $requestType el metodo request GET | POST
     */
    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {

            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );

        }

        //throw new Exception('No route defined for this URI.');

        redirect("sorry");
    }

    /**
     * Llamar al controlador y su accion
     * @param string $controller El controller o clase
     * @param string $action La accion o funcion
     */
    protected function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";

        $controller = new $controller();

        if (!method_exists($controller, $action)) {

            redirect("sorry");       

        }

        return $controller->$action();
        
    }

}