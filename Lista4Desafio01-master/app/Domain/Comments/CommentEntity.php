<?php

namespace App\Domain\Comments;

class CommentEntity
{
    public string $id;
    public string $post_id;
    public string $author_id;
    public string $content;

    public function __construct(string $id, string $post_id, string $author_id, string $content)
    {
        $this->id = $id;
        $this->post_id = $post_id;
        $this->author_id = $author_id;
        $this->content = $content;
    }
}