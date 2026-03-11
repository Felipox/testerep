<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Comment extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'post_id',
        'author_id',
        'content'
    ];
}
