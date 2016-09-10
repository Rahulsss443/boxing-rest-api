<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrediction extends Model
{

    protected $table = 'user_prediction';
    protected $fillable = ['fight_id', 'user_id', 'prediction_id'];
   
}