# Laravel Better Soft Delete
[![Build Status](https://travis-ci.org/lybc/laravel-better-softdelete.svg?branch=master)](https://travis-ci.org/lybc/laravel-better-softdelete)
![StyleCI build status](https://github.styleci.io/repos/160794118/shield) 
![](https://img.shields.io/apm/l/vim-mode.svg?style=flat-square)

## Installing

```bash
$ composer require lybc/laravel-better-softdelete -vvv
```

## Usage

### 在migrate中添加数据库结构
```php
public function up()
{
    Schema::create('some_tables', function (Blueprint $table) {
        $table->increments('id');
        $table->timestamps();
        ...
        $table->betterSoftDeletes();
    });
}

public funtion down() 
{
    Schema::table('some_tables', function (Blueprint $table) {
       ...
       $table->dropBetterSoftDeletes();
    });
}
```

### 在 model 中 use Trait

```php
use Lybc\BetterSoftDelete\BetterSoftDeletes;

class SomeModel extends Model
{
    use BetterSoftDeletes;
}
```

完成以上操作即可使用 Laravel 提供的 API 进行软删除

[example](https://github.com/lybc/laravel-better-softdelete/blob/master/tests/DbSchemaTest.php)

如果没有使用本包提供的方式定义软删除字段，可以在模型中定义常量重写软删除字段

```php
class SomeModel extends Model
{
    const DELETED_AT_COLUMN = 'deleted';
}
```

### 级联删除

本包提供级联删除支持，当模型之间存在关联关系时，父模型删除连带删除子模型

```php
use Lybc\BetterSoftDelete\BetterSoftDeletes;
class Post extends Model
{
    use BetterSoftDeletes;
    
    // 定义需要级联删除的关联关系
    protected $cascadeDeletes = [
        'comments'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

```

## License

MIT

## thanks
[package-builder](https://github.com/overtrue/package-builder)

[michaeldyrynda/laravel-cascade-soft-deletes](https://github.com/michaeldyrynda/laravel-cascade-soft-deletes)

[http://blog.dreamlikes.cn/archives/892](http://blog.dreamlikes.cn/archives/892)

