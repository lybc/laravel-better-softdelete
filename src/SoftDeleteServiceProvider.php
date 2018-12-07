<?php

namespace Lybc\BetterSoftDelete;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

/**
 * Class SoftDeleteServiceProvider
 * @package Lybc\BetterSoftDelete
 */
class SoftDeleteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // define soft delete db schema
        Blueprint::macro('betterSoftDeletes', function () {
            return $this->integer('deleted_at')->default(0)->comment('soft deletes flag');
        });
        Blueprint::macro('dropBetterSoftDeletes', function () {
            return $this->dropColumn('deleted_at');
        });
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
