<?php
namespace Lybc\BetterSoftDelete\Tests;

use \Illuminate\Database\Schema\Blueprint;
use Lybc\BetterSoftDelete\SoftDeleteServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
        $this->withFactories(__DIR__.'/database/factories');
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'betterdelete');
        $app['config']->set('database.connections.betterdelete', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function setUpDatabase(\Illuminate\Foundation\Application $app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('age');
            $table->betterSoftDeletes();
        });

        $app['db']->connection()->getSchemaBuilder()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->unsignedInteger('user_id');
            $table->betterSoftDeletes();
        });

        $app['db']->connection()->getSchemaBuilder()->create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->string('content');
            $table->betterSoftDeletes();
        });
    }


    protected function getPackageProviders($app)
    {
        return [SoftDeleteServiceProvider::class];
    }
}
