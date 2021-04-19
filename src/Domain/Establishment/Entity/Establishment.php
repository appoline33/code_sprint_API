<?php

namespace App\Domain\Establishment\Entity;

use App\Domain\Catalog\Entity\Category;
use App\Domain\Catalog\Entity\Product;
use App\Domain\Thumbnail\Thumbnail;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Establishment extends Model
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

    public function thumbnails()
    {
        return $this->morphMany(Thumbnail::class, 'thumbnaible');
    }

    public function hours()
    {
        return $this->hasMany(Hour::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
