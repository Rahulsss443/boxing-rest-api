<?php

namespace App\Models;

use App\Models\Fighter;
use Illuminate\Database\Eloquent\Model;

class Fight extends Model
{

    protected $table = 'fights';
    protected $fillable = [
        'fighter1_id',
        'fighter2_id',
        'rounds'
    ];

    public function fighter1()
    {
        return $this->belongsTo(Fighter::class, 'fighter1_id', 'id');
    }
    public function fighter2()
    {
        return $this->belongsTo(Fighter::class, 'fighter1_id', 'id');
    }

   
}