<?php

namespace App\Infrastructure\Eloquent;

use App\Domain\Users\UserRepositoryInterface;
use App\Domain\Users\UserEntity;
use App\Models\User;


class UserEloquentRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findById(string $id): ?UserEntity
    {
        $user_model = $this->model->where('id', $id)->first();
        return $this->toEntity($user_model);
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $user_model =  $this->model->where('email', $email)->first();

        if(!$user_model)
            {
                return null;
            }
            
        return $this->toEntity($user_model);

    }

    public function create(array $data): UserEntity
    {
        $user_model = $this->model->create($data);
        return $this->toEntity($user_model);
    }

    private function toEntity(User $model):UserEntity
    {
        return new UserEntity(
            $model->id,
            $model->name,
            $model->email,
            $model->password
        );
    }


    public function createAuthToken(string $user_id, string $token): string
    {
        $user_model = $this->model->findOrFail($user_id);
        return $user_model->createToken($token)->plainTextToken;
    }
}