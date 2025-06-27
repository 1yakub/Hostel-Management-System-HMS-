<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $casts = [
        'gallery_images' => 'array',
        'amenities' => 'array'
    ];

    protected $fillable = [
        'room_number',
        'capacity',
        'price_per_night',
        'status',
        'featured_image',
        'gallery_images',
        'description',
        'room_type',
        'amenities'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
