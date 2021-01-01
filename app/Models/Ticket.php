<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Ticket extends Model
{
    use HasFactory, Uuid;

    protected $keyType = 'string';

    public $incrementing = false;

    public $append = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booker_id',
        'movie_screen_id',
        'seat_id',
        'reference',
        'price',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'booker_id' => 'string',
        'movie_screen_id' => 'string',
        'seat_id' => 'string',
        'reference' => 'string',
        'price' => 'integer'
    ];

    /**
     * Get all of the ticket's order detail.
     */
    public function order_details()
    {
        return $this->morphMany(OrderDetail::class, 'order_detailable');
    }

    /**
     * Get the show time that owns the ticket.
     */
    public function movie_screen()
    {
        return $this->belongsTo(MovieScreen::class);
    }
    
}
