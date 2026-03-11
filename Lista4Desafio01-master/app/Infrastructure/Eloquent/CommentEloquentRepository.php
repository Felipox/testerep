<?php

namespace App\Infrastructure\Eloquent;

use App\Domain\Comments\CommentRepositoryInterface;
use App\Domain\Comments\CommentEntity;
use App\Models\Comment;

class CommentEloquentRepository implements CommentRepositoryInterface
{
    protected $model;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
    public function create(array $data): CommentEntity
    {
        $comment = $this->model->create($data);
        return $this->toEntity($comment);
    }
    public function findPostById(string $post_id): array
    {
        $comment = $this->model->where("post_id", $post_id)->get();
        
        return $comment->map(fn(Comment $comment) => $this->toEntity($comment))->toArray();
        
    }
    public function findById(string $id):? CommentEntity
    {
        $comment = $this->model->where("id", $id)->first();
        if(! $comment) {
            return null;
        }

        return $this->toEntity($comment);
    }
    public function delete(string $id): bool
    {
        $comment = $this->model->where("id", $id)->first();
        if(!$comment)
            {
                return false;
            }
        $comment->delete();
        return true;
    }

    private function toEntity(Comment $model):CommentEntity
    {
        return new CommentEntity(
            $model->id,
                $model->post_id,
                $model->author_id,
                $model->content
        );
    }
}