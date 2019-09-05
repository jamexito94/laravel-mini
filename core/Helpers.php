<?php

if(!function_exists('view')){
    /**
     * Funcion que retorna la vista de app/views
     * @param string $name Nombre de la vista
     * @param array $data Los datos a pasar a la vista
     */
    function view($name, array $data = [])
    {
        $ruts = explode(".",$name);
        $count = count($ruts);
        $req = "";
        if ($count == 1) {
            $req ="../resources/view/{$name}.view.php";
        }
        else{
            $req = "app/views/";
            for ($i=0; $i < $count; $i++) { 
                if ($i != $count - 1) {
                    $req .= $ruts[$i] . "/";
                }
                else {
                    $req .= "{$ruts[$i]}.view.php";
                }
            }
        }
        
        extract($data);

        require ($req);

    }
}



if(!function_exists('redirect')){
    /**
     * Funcion de redireccionamiento a la ruta especificada
     * @param string $path Nombre de la ruta
     */
    function redirect($path)
    {
        header("Location: /{$path}");
    }
}


if(!function_exists('component')){
    /**
     * Funccion de requerir componente
     * @param string $ruta Establecer ruta de la carpeta views
     * @param array $data Pasar valores
     */

    function component($ruta,$data = []){

        $index_component = "app/views/components/";
        $ruta_component = explode(".", $ruta);
        $lent_component = count($ruta_component);
        $req_component = $index_component;

        if ($lent_component == 1) {
            $req_component .= "{$ruta}.component.php";
        }
        else{
            for ($i = 0; $i < $lent_component; $i++) {
                if ($i != $lent_component - 1) {
                    $req_component .= $ruta_component[$i] . "/";
                } else {
                    $req_component .= "{$ruta_component[$i]}.component.php";
                }
            }
        }

        extract($data);

        require($req_component);

    }
}


if(!function_exists('assets')){
    /**
     * Funcion que obtiene el acceso la carpeta publica
     * 
     * @param string $uri
     * 
     */

    function assets($uri)
    {   

        $protocolo = App::get("config")["host"]["protocolo"];

        $host = App::get("config")["host"]["dominio"];

        echo $protocolo . $host . "/public/" . $uri;

    }
}


/**
 * Funcion que obtiene el acceso la carpeta publica sin argumentos
 *
 * 
 */

if(!function_exists('asset')){
    function asset()
    {
    
        $protocolo = App::get("config")["host"]["protocolo"];
    
        $host = App::get("config")["host"]["dominio"];
    
        return $protocolo . $host . "/public/";
    }
}


if(!function_exists('title')){
    /**
     *  Obtiene el titulo de tu pagina web
     * 
     */

    function title()
    {

        $title = App::get("config")["mySite"]["name"];

        return $title;

    }
}



if(!function_exists('convertDataSimple')){
    /**
     *  Convierte un array object de una solicitud a la base
     *  de datos a un array simple
     *  @param Object $obj
     *  @param array $parameters
     * 
     */

    function convertDataSimple($obj, $parameters)
    {
        $final = [];

        for ($i = 0; $i < count($parameters); $i++) {
            $parameter = $parameters[$i];
            $final[$parameter] = "";
        }

        foreach ($obj as $value) {
            for ($i = 0; $i < count($parameters); $i++) {
                $parameter = $parameters[$i];
                $final[$parameter] = $value->$parameter;
            }
        }

        return $final;
    }
}