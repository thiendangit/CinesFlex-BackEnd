<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Seat extends Model
{
    use HasFactory, Uuid;

    protected $keyType = 'string';

    public $incrementing = false;

    // status
    const IS_AVAILABLE = 1;
    const IS_RESERVED = 2;

    // type
    const NORMAL = 1;
    const VIP = 2;

    protected $appends = ['fee_percent'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seat_row_id',
        'screen_id',
        'name',
        'description',
        'type',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'screen_id',
        'seat_row_id',
        'description',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'seat_row_id' => 'string',
        'screen_id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'type' => 'integer',
        'status' => 'integer'
    ];

    public function getFeePercentAttribute()
    {
        return $this->type == Seat::VIP ? 10 : 0;
    }

    public function seatRow()
    {
        return $this->belongsTo(SeatRow::class);
    }

}
