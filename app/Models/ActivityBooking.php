<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityBooking extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'activity_id',
        'number_people',
        'price',
        'activity_date',
    ];
}
