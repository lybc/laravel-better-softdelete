<?php

namespace Lybc\BetterSoftDelete\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Lybc\BetterSoftDelete\BetterSoftDeletes;

class Comment extends Model
{
    use BetterSoftDeletes;

    public $timestamps = false;

    protected $table = 'comments';
}
