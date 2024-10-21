<?php

namespace App\Http\Controllers;

use App\Models\UserMonitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //Criando novos usuarios.
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:user_monitoring',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = UserMonitoring::create($validatedData);

        return response()->json(['message' => 'Usuário criado com sucesso!']);
    }

    public function login(Request $request)
    { 
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
    
            if (Auth::guard('user_monitoring')->attempt($credentials)) {
                $user = Auth::guard('user_monitoring')->user();
                $token = $user->createToken('TokenName')->plainTextToken;
    
                return response()->json([
                    'status' => 1,
                    'message' => 'Login bem-sucedido!',
                    'Bearer Token' => $token, 
                ]);
            }
    
            return response()->json([
                'status' => 0,
                'message' => 'As credenciais fornecidas estão incorretas.'
            ], 401);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Erro ao realizar login.' . $e->getMessage()
            ],500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
