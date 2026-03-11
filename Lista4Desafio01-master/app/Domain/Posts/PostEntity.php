<?php

namespace App\Domain\Posts;

use App\Domain\Posts\PostStatus;


class PostEntity
{
    public string $id;
    public string $title;
    public string $text;
    public string $author_id;
    public PostStatus $status;


    public function __construct(string $id, string $title, string $text, string $author_id, PostStatus $status)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->author_id = $author_id;
        $this->status = $status;
    }
}