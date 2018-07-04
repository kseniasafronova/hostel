<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['room_id', 'place_count','date_in' ,'date_out', 'booking_status', 'guest_FN', 'guest_LN', 'guest_email','date','prepaid'];
}
