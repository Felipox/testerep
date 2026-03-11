<?php

namespace App\Domain\Users;

use App\Domain\Users\UserEntity;

interface UserRepositoryInterface 
{
    public function findById(string $id): ?UserEntity;
    public function findByEmail(string $email): ?UserEntity;
    public function create(array $data): UserEntity;
    public function createAuthToken(string $user_id, string $token): string;
}