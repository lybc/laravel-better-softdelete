<?php

namespace Lybc\BetterSoftDelete\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Lybc\BetterSoftDelete\BetterSoftDeletes;

class User extends Model
{
    use BetterSoftDeletes;

    protected $table = 'users';

    public $timestamps = false;
}
