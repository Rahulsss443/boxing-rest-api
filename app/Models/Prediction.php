<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{

    protected $table = 'predictions';

    public function status($fight)
    {
        $predictionCount = UserPrediction::where('fight_id', $fight->id)
                                        ->where('prediction_id', $this->id)
                                        ->count();
        return  ((int) (($predictionCount/$fight->totalPredictions())*100));
    }
}
