<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'priority',
        'start',
        'end',
        'description',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    public $timestamps = false;

    public function getRemainingDaysAttribute()
    {
        $startTimestamp = time();
        $endTimestamp = $this->end->timestamp;
        $secondsInDay = 24 * 60 * 60;

        $remainingDays = max(0, floor(($endTimestamp - $startTimestamp) / $secondsInDay));

        return $remainingDays;
    }

    public function getTotalDaysAttribute()
    {
        $startTimestamp = $this->start->timestamp;
        $endTimestamp = $this->end->timestamp;
        $secondsInDay = 24 * 60 * 60;

        $totalDays = floor(($endTimestamp - $startTimestamp) / $secondsInDay);

        return $totalDays;
    }
}
