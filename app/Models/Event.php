<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'type','asesrar_id','title','start','end','available_date', 'availability','add_event_descp'
    ];

    protected $table = 'events_record';

}
