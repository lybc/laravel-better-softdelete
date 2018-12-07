# Laravel Better Soft Delete

## Installing

```bash
$ composer require lybc/laravel-better-softdelete -vvv
```

## Usage

在migrate中添加数据库结构
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

在model中use Trait

```php
use Lybc\BetterSoftDelete\BetterSoftDeletes;

class SomeModel extends Model
{
    use BetterSoftDeletes;
}
```

完成以上操作即可使用 Laravel 提供的 API 进行软删除

[example](https://github.com/lybc/laravel-better-softdelete/blob/master/tests/DbSchemaTest.php)

## License

MIT

## thanks
[package-builder](https://github.com/overtrue/package-builder)

[http://blog.dreamlikes.cn/archives/892](http://blog.dreamlikes.cn/archives/892)

