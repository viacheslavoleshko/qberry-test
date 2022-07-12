<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'room_id',
        'user_id',
        'volume',
        'days',
        'debt',
    ];

    protected $hidden = [
        'access_code',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public static function boot() {
        parent::boot();

        self::creating(function ($model) {
            $model->access_code = Str::random(12);
        });
    }
}
