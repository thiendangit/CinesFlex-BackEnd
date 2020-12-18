<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class OrderDetail extends Model
{
    use HasFactory, Uuid;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'order_detailable_id',
        'order_detailable_type',
        'quantity',
        'total'
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
        'order_id' => 'string',
        'order_detailable_id' => 'string',
        'order_detailable_type' => 'string',
        'quantity' => 'integer',
        'total' => 'integer'
    ];

    /**
     * Get all of the owning orderdetailable models.
     */
    public function order_detailable()
    {
        return $this->morphTo();
    }
}
