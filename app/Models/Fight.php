<?php

namespace App\Models;

use App\Models\Fighter;
use App\Models\UserPrediction;
use Illuminate\Database\Eloquent\Model;
use Auth;

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

    public function isPredicted()
    {
        $data = [
            'fight_id' => $this->id,
            'user_id' => Auth::user()->id,
        ];

        return (UserPrediction::where($data)->first())?true :false;

    }

   
}