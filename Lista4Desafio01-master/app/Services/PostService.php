<?php

namespace App\Services;

use App\Domain\Posts\PostEntity;
use App\Domain\Posts\PostRepositoryInterface;
use App\Domain\Posts\PostStatus;


class PostService
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function createPost(array $data, string $author_id):PostEntity
    {
        $data["author_id"] = $author_id;
        $data["status"] = PostStatus::PUBLISHED->value;

        return $this->postRepository->create($data);
    }

    public function findPostById(string $id): ?PostEntity
    {
        return $this->postRepository->findById($id);
    }

    public function updatePost(string $id, array $data): ?PostEntity
    {
        $post = $this->postRepository->findById($id);

        if(!$post)
            {
                return null;
            }
        
        return $this->postRepository->update($id, $data);
    }

    public function deletePost(string $id): void
    {
        $this->postRepository->delete($id);
    }

    public function listAllPosts():array
    {
        return $this->postRepository->findAllPublished();
    }

    public function archivePost(string $id): bool
    {
        $post = $this->postRepository->findById($id);

        if(!$post)
        {
            return false;
        }

        return $this->postRepository->updateStatus($id, PostStatus::ARCHIVED);
    }
}