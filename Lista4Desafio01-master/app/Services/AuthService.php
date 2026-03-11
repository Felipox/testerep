<?php

namespace App\Services;

use App\Domain\Users\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;



class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data):string
    {

        $data['password'] = Hash::make($data["password"]);

        $user = $this->userRepository->create($data);

        $token = $this->userRepository->createAuthToken($user->id, 'auth_token');

        return $token;
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if(empty($user)) 
        {
            throw new Exception('Erro: Email inexistente', 404);
        }

        if (!Hash::check($credentials['password'], $user->password)) 
        {
            throw new Exception('Erro: Senha incorreta', 401);
        }

        $token = $this->userRepository->createAuthToken($user->id, 'auth_token');
        return $token;
    }

    public function logout($user):void
    {
        $user->currentAccessToken()->delete();
    }
}