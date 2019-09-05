<?php

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
