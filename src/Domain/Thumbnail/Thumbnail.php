<?php

namespace App\Domain\Thumbnail;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Thumbnail extends Model
{
    use Uuid;

    /* The "type" of the auto-incrementing ID.
    *
    * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function thumbnaible()
    {
        return $this->morphTo();
    }
}
