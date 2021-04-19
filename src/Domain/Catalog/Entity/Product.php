<?php

namespace App\Domain\Catalog\Entity;

use App\Domain\Establishment\Entity\Establishment;
use App\Domain\Thumbnail\Thumbnail;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Product extends Model
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

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'product_variants');
    }

    public function thumbnails()
    {
        return $this->morphMany(Thumbnail::class, 'thumbnaible');
    }
}
