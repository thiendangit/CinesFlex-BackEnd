<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Product extends Model
{
    use HasFactory, Uuid;

    protected $keyType = 'string';

    public $incrementing = false;

    const FASTFOOD = 1;
    const SOFTDRINK = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'name',
        'description',
        'price',
        'type',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'reference' => 'string',
        'name' => 'string',
        'description' => 'string',
        'price' => 'integer',
        'type' => 'integer',
        'status' => 'integer'
    ];

    /**
     * Get all of the product's order detail.
     */
    public function order_details()
    {
        return $this->morphMany(OrderDetail::class, 'order_detailable');
    }

     /**
     * Get the product's image.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
