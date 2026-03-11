<?php

namespace App\Domain\Posts;

use App\Domain\Posts\PostEntity;
use App\Domain\Posts\PostStatus;

interface PostRepositoryInterface
{
    public function create(array $data): PostEntity;
    public function update(string $id, array $data): ?PostEntity;
    public function delete(string $id): bool;
    public function findById(string $id): ?PostEntity;
    public function updateStatus(string $id, PostStatus $status):bool;
    public function findAllPublished():array;
}