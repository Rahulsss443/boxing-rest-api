<?php

namespace App\Models;

use App\Models\FightResult;
use App\Models\Fighter;
use App\Models\Outcome;
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
                    $data[$i]['id'] = $prediction->id;
                    $data[$i]['prediction'] = $this->fighter1->name.' '.$prediction->display_name;
                    $data[$i]['status'] = $prediction->status($this);
                    $i++;
                  break;
                case 'fighter1-distance':
                    $data[$i]['id'] = $prediction->id;
                    $data[$i]['prediction'] = $this->fighter1->name.' '.$prediction->display_name;
                    $data[$i]['status'] = $prediction->status($this);
                    $i++;
                  break;
                case 'draw':
                    $data[$i]['id'] = $prediction->id;
                    $data[$i]['prediction'] = $prediction->display_name;
                    $data[$i]['status'] = $prediction->status($this);
                    $i++;
                  break;
            case 'fighter2-on-points':
                    $data[$i]['id'] = $prediction->id;
                    $data[$i]['prediction'] = $this->fighter2->name.' '.$prediction->display_name;
                    $data[$i]['status'] = $prediction->status($this);
                    $i++;
                  break;
            case 'fighter2-distance':
                    $data[$i]['id'] = $prediction->id;
                    $data[$i]['prediction'] = $this->fighter2->name.' '.$prediction->display_name;
                    $data[$i]['status'] = $prediction->status($this);
                    $i++;
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

    public function totalPredictions()
    {
        return UserPrediction::where('fight_id', $this->id)->count();
    }

    public static function formalFights()
    {
       return  self::where('custome', 0)->get();
    }

    public static function customeFights() {
       return  self::where('custome', 1)->get();
    }

    public function scores()
    {

        $data = ['fight_id' => $this->id, 'user_id' => Auth::user()->id];
        $scoreFighter1 = 0;
        $scoreFighter2 = 0;

        $Results =  FightResult::where($data)
                                ->get();

        foreach ($Results as $result) {
            $scoreFighter1 += (int)$result->fighter1_score;
            $scoreFighter2 += (int)$result->fighter2_score;
        }


        $outcome = FightResult::where($data)
                                ->where('outcome_id', '>', 0)
                                ->first();


        if ($outcome) {

            $outcomeAbbr = Outcome::find($outcome->outcome_id)->abbr;
             
            $winner = Fighter::find($outcome->winner);
            if ($winner->id == $this->fighter1->id) {
                $scoreFighter1 = 'W'.$scoreFighter1.'/'.$outcomeAbbr.''.$outcome->round_no;
                $scoreFighter2 = 'L'.$scoreFighter2.'/'.$outcomeAbbr.''.$outcome->round_no;
            } else {
                $scoreFighter1 = 'L'.$scoreFighter1.'/'.$outcomeAbbr.''.$outcome->round_no;
                $scoreFighter2 = 'W'.$scoreFighter2.'/'.$outcomeAbbr.''.$outcome->round_no;
            }
        }

        return [
                'fighter1'=> $scoreFighter1,
                'fighter2'=> $scoreFighter2
                ];
    }
}
