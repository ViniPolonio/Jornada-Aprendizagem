<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Validar as credenciais fornecidas
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        // Se a autenticação falhar, retornar com um erro
        return response()->json([
            'status' => 0,
            'message' => 'As credenciais fornecidas estão incorretas.'
        ], 401);
    }

    // Função de logout
    public function logout(Request $request)
    {
        // Realizar logout do usuário
        Auth::logout();

        // Invalidar a sessão
        $request->session()->invalidate();

        // Regenerar o token CSRF
        $request->session()->regenerateToken();

        // Redirecionar para a página de login ou inicial
        return redirect('/login');
    }
}
