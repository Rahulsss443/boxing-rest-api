<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{

    protected $table = 'predictions';
    protected $fillable = ['fight_id', 'user_id', 'prediction_id'];
   
}