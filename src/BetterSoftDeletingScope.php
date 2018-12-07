<?php
/**
 * Created by PhpStorm.
 * User: outlaws
 * Date: 2018/12/7
 * Time: 11:41 AM
 */

namespace Lybc\BetterSoftDelete;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope as BaseScope;

class BetterSoftDeletingScope extends BaseScope
{
    /**
     * rewrite query for undeleted data
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedDeletedAtColumn(), 0);
    }

//    public function extend(Builder $builder)
//    {
//        foreach ($this->extensions as $extension) {
//            $this->{"add{$extension}"}($builder);
//        }
//        $builder->onDelete(function (Builder $builder) {
//            $column = $this->getDeletedAtColumn($builder);
//            return $builder->update([
//                $column => time()
//            ]);
//        });
//    }

    /**
     * Add the restore extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function addRestore(Builder $builder)
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withTrashed();

            return $builder->update([$builder->getModel()->getDeletedAtColumn() => 0]);
        });
    }

    /**
     * Add the without-trashed extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutTrashed(Builder $builder)
    {
        $builder->macro('withoutTrashed', function (Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this)
                ->where($model->getQualifiedDeletedAtColumn(), 0);
            return $builder;
        });
    }

    /**
     * Add the only-trashed extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this)
                ->where($model->getQualifiedDeletedAtColumn(), '>', 0);
            return $builder;
        });
    }
}
