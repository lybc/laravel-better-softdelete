<?php

namespace Lybc\BetterSoftDelete;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Trait BetterSoftDeletes
 * @package Lybc\BetterSoftDelete
 */
trait BetterSoftDeletes
{
    use SoftDeletes;

    /**
     * get soft delete column
     * @return string
     */
    public function getDeletedAtColumn()
    {
        return 'deleted_at';
    }

    /**
     * apply soft delete scope
     */
    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new BetterSoftDeletingScope());
    }

    protected function runSoftDelete()
    {
        $query = $this->newQueryWithoutScopes()->where($this->getKeyName(), $this->getKey());
        $this->{$this->getDeletedAtColumn()} = $time = time();
        $query->update([
            $this->getDeletedAtColumn() => $time
        ]);
    }


    public function restore()
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }
        $this->{$this->getDeletedAtColumn()} = 0;
        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;
        $result = $this->save();
        $this->fireModelEvent('restored', false);
        return $result;
    }


    /**
     * model was deleted
     * @return bool
     */
    public function trashed()
    {
        return ! ($this->{$this->getDeletedAtColumn()} === 0);
    }
}