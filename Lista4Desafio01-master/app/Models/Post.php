<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Post extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'title',
        'content',
        'author_id',
        'status'
    ];
}
