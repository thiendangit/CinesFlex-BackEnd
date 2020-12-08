<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Movie extends Model
{
    use HasFactory, Uuid;

    protected $keyType = 'string';

    public $incrementing = false;

    const ISCOMMING = 1;
    const NOWSHOWING = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
        'name' => 'string',
        'type' => 'integer',
        'status' => 'integer'
    ];

    public function detail()
    {
        return $this->hasOne(MovieDetail::class);
    }

    public function casters()
    {
        return $this->belongsToMany(Caster::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }
}
