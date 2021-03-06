<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Carbon\Carbon;

class MovieScreen extends Model
{
    use HasFactory, Uuid;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $appends = ['day', 'day_of_week', 'price', 'date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie_id',
        'screen_id',
        'cinema_id',
        'show_time',
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
        'movie_id' => 'string',
        'screen_id' => 'string',
        'cinema_id' => 'string',
        'show_time' => 'datetime',
        'type' => 'integer',
        'status' => 'integer'
    ];

    function getDayAttribute() {
        $date = new Carbon($this->show_time);

        return $date->day;
    }

    function getDayOfWeekAttribute() {
        $date = new Carbon($this->show_time);
        $dayOfWeeks = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        return  $dayOfWeeks[$date->dayOfWeek];
    }

    function getPriceAttribute() {
        return MovieDetail::where('movie_id', $this->movie_id)->get()[0]->price ?? 0;
    }

    function getDateAttribute() {
        $date = new Carbon($this->show_time);

        return $date->toFormattedDateString();
    }

     /**
     * Set the show time value
     *
     * @param  string  $value
     * @return void
     */
    public function setShowTimeAttribute($value)
    {
        $this->attributes['show_time'] = $value;
    }
    
     /**
     * Get the screen that owns the movie screen.
     */
    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    /**
     * Get the movie that owns the movie screen.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
