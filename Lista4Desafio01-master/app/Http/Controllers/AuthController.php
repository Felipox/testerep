<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $auth_service;
    
    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    public function register(RegisterUserRequest $request)
    {
        $validated_data = $request->validated();
            
        try{
        $token = $this->auth_service->register((array)$validated_data);

        return response()->json([
            'message'=> 'Sucesso: usuario registrado',
            'access_token'=> $token,
            'token_type'=> 'Bearer'
        ], 201);
        }
        catch(\Exception $e){
            return response()->json(['Erro'=> $e->getMessage()], $e->getCode()?: 500);
        }
    }

    public function login(LoginUserRequest $request)
    {
        $validated_data = $request->validated();
            
        try{
        $token = $this->auth_service->login($validated_data);

        return response()->json([
            'message' => 'Sucesso: login feito',
            'access_token'=> $token,
            'token_type'=> 'Bearer'
        ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'Erro'=> $e->getMessage() 
            ], $e->getCode()?: 500);
        }
    }

    public function logout(Request $request)
    {
        try
        {
            $this->auth_service->logout($request->user());

            return response()->json(null, 204);
        }
        catch (\Exception $e){
            return response()->json(['Erro:'=> $e->getMessage()], 500);
        }
    }
}