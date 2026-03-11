<?php

namespace App\Infrastructure\Eloquent;

use App\Domain\Posts\PostRepositoryInterface;
use App\Domain\Posts\PostEntity;
use App\Domain\Posts\PostStatus;
use App\Models\Post;

class PostEloquentRepository implements PostRepositoryInterface
{
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function create(array $data):PostEntity
    {
        $post_model = $this->model->create($data);
        return $this->toEntity($post_model);
    }

    public function update(string $id, array $data): ?PostEntity
    {
        $post_model = $this->model->where('id', $id)->first();

        if(!$post_model)
            {
                return null;
            }

        $post_model->update($data);

        return $this->toEntity($post_model);

    }

    public function delete(string $id): bool
    {
        $post_model = $this->model->where('id', $id)->first();
        if (!$post_model)
            {
                return false;
            }
            $post_model->delete();
            return true;
    }

    public function findById(string $id): ?PostEntity
    {
        $post_model = $this->model->where('id', $id)->first();

        if (!$post_model)
        {
            return null;
        }

        return $this->toEntity($post_model);
    }

    public function updateStatus(string $id, PostStatus $status):bool
    {
        $post_model = $this->model->where('id', $id)->first();
        if (!$post_model)
            {
                return false;
            }
        $post_model->status = $status->value;
        $post_model->save();

        return true;
    }

    private function toEntity(Post $model):PostEntity
    {
        return new PostEntity(
            $model->id,
            $model->title,
            $model->content,
            $model->author_id,
            PostStatus::from($model->status)
        );
    }

    public function findAllPublished():array
    {
        $posts = $this->model->where('status', PostStatus::PUBLISHED->value)
        ->orderBy('created_at', 'desc')->get();

        return $posts->map(function (Post $post) {
        return $this->toEntity($post);
        })->toArray();
    }
}
