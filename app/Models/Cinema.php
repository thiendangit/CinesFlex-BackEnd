<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Cinema extends Model
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
        'region_id',
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
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'region_id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'type' => 'integer',
        'status' => 'integer'
    ];

    public function screens()
    {
        return $this->hasMany(Screen::class);
    }

    public function show_times()
    {
        return $this->hasMany(MovieScreen::class);
    }

    /**
     * Get the cinema's image.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
