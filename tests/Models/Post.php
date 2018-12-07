<?php

namespace Lybc\BetterSoftDelete\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Lybc\BetterSoftDelete\BetterSoftDeletes;

class Post extends Model
{
    use BetterSoftDeletes;

    protected $table = 'posts';

    public $timestamps = false;


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
