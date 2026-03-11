<?php

namespace App\Services;

use App\Domain\Comments\CommentEntity;
use App\Domain\Comments\CommentRepositoryInterface;
use App\Domain\Posts\PostRepositoryInterface;
use App\Domain\Posts\PostStatus;
use Exception;

class CommentService
{
    protected CommentRepositoryInterface $comment;
    protected PostRepositoryInterface $post;
    public function __construct(CommentRepositoryInterface $comment, PostRepositoryInterface $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    public function listByPost(string $post_id): array
    {
        $post = $this->post->findById($post_id);
        if(!$post)
            {
                throw new Exception("Erro: Post nao encontrado",404);
            }
        
        return $this->comment->findPostById($post_id);
    }

    public function create(array $data):CommentEntity
    {
        $post = $this->post->findById($data['post_id']);

        if (!$post) {
            throw new Exception("Post nao encontrado", 404);
        }

        if ($post->status === PostStatus::ARCHIVED) {
            throw new Exception("Nao e possivel comentar em posts arquivados", 422);
        }

        return $this->comment->create($data);
    }

    public function findById(string $id):? CommentEntity
    {
        $comment = $this->comment->findById($id);
        if (!$comment) 
        {
            throw new Exception("Erro: Comentario nao encontrado", 404);
        }
        return $comment;
    }

    public function delete(string $id):bool
    {
        $comment = $this->comment->findById($id);
        if (!$comment) 
        {
            throw new Exception("Erro: Comentario nao encontrado", 404);
        }

        return $this->comment->delete($id);
    }
}