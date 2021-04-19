<?php

namespace App\Domain\Establishment\Entity;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Hour extends Model
{
    use Uuid;

    /* The "type" of the auto-incrementing ID.
    *
    * @var string
     */
    protected $keyType = 'string';


    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
}
