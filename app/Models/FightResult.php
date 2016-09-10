<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FightResult extends Model
{

    protected $table = 'fight_result';
    protected $fillable = ['fight_id', 'round_no', 'fighter1_score', 'fighter2_score', 'outcome_id', 'winner', 'user_id'];
   
}