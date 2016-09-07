<?php

namespace App\Models;

use App\Models\Fighter;
use App\Models\Prediction;
use App\Models\UserPrediction;
use Auth;
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
        return $this->belongsTo(Fighter::class, 'fighter2_id', 'id');
    }

    public function isPredicted()
    {
        $data = [
            'fight_id' => $this->id,
            'user_id' => Auth::user()->id,
        ];
        return (UserPrediction::where($data)->first())?true :false;
    }
    
    public function makePrediction($predictionID = 0)
    {
        $data = [
            'fight_id' => $this->id,
            'prediction_id'=>$predictionID,
            'user_id' => Auth::user()->id,
        ];
        UserPrediction::firstOrCreate($data);
        return $predictionID;
    }

    public function allPredictions()
    {
        $predictions =  Prediction::all();
        $data = [];
        $i =0;
        foreach ($predictions as $prediction) {
            switch ($prediction->name) {
              case 'fighter1-on-points':
                 $data[] = $this->fighter1->name.' '.$prediction->display_name;
                  break;
            case 'fighter1-distance':
                 $data[] = $this->fighter1->name.' '.$prediction->display_name;
                  break;
            case 'draw':
                  $data[] = $prediction->display_name;
                  break;
            case 'fighter2-on-points':
                  $data[] = $this->fighter2->name.' '.$prediction->display_name;
                  break;
            case 'fighter2-distance':
                  $data[] = $this->fighter2->name.' '.$prediction->display_name;
                  break;
          }
        }
        return $data;
    }

    public function predictionID()
    {
        $data = [
            'fight_id' => $this->id,
            'user_id' => Auth::user()->id,
        ];
        $prediction = UserPrediction::where($data)->first();
        if ($prediction) {
            return $prediction->id;
        }

        return null;
    }
}
