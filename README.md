# laravel-mini
Como entender la funcionalidad de Laravel? Este es un buen ejemplo para entender.


##Inicializar el project
La carpeta root se encuentra en el folder public/. Por tanto tendras que iniciar este comando:

```
php -S localhost:8081 -t public
```

##El enrutador
Las rutas se definen en el folder router/web.php. Este es un ejemplo:

```
<?php

$router->get('', 'HomeController@home');
```

##Eres libre de crear tu BASE DE DATOS
Usa un helper function database(), que trae un objeto de QueryBiulder class. Puedes definir los metodos GET y POST. Este es un ejemplo.

```
namespace App\Controllers;


class HomeController  
{
    public function home()
    {
        $users = database()->table('users')
                            ->select(['id', 'name', 'age'])
                            ->where('name', '=', 'Daniel Ponce')
                            ->where('age', '=', 19)
                            ->get();

        return view('home', ['users' => $users]);
    }
}
```
