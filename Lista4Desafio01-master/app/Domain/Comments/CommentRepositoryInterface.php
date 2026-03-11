<?php

namespace App\Domain\Comments;

use App\Domain\Comments\CommentEntity;

interface CommentRepositoryInterface
{
    public function create(array $data): CommentEntity;
    public function findPostById(string $post_id): array;
    public function findById(string $id):? CommentEntity;
    public function delete(string $id): bool;
}