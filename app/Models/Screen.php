<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Carbon\Carbon;

class Screen extends Model
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
        'cinema_id',
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'cinema_id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'type' => 'integer',
        'status' => 'integer'
    ];

    /**
     * Get the screen that owns the cinema.
     */
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * Get the seat that owns the screen.
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
