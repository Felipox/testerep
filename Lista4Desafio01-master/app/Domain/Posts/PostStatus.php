<?php

namespace App\Domain\Posts;

enum PostStatus: string
{
    case PUBLISHED = 'PUBLISHED';
    case DRAFT = 'DRAFT';
    case ARCHIVED = 'ARCHIVED';
}