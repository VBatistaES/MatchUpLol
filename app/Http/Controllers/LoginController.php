<?php

namespace App\Http\Controllers;

use App\Models\User;
use HasFactory, Notifiable;

class LoginController extends User
{
    public function login()
    {   
        $usuario = [
            'nome'=> 'Vitor',
            'idade'=> 18,
            'senha'=> 2412345,
        ];

        $login = false;
        
        $nome = $usuario['nome'];
        $senha = $usuario['senha'];

        if ($nome === 'Vitor' && $senha === 2412345) {
            $login = true;
        };
    }
}
