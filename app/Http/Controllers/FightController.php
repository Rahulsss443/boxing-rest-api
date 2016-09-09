<?php
 namespace App\Http\Controllers;

use App\Models\Fight;
use App\Models\Fighter;
use Illuminate\Http\Request;
use Auth;

class FightController extends Controller
{

    public function create(Request $request)
    {
        $fighter1 = Fighter::firstOrCreate(['name' => $request->fighter1 ])->id;
        $fighter2 = Fighter::firstOrCreate(['name' => $request->fighter2 ])->id;
        
        $fight = Fight::firstOrCreate([
                'fighter1_id' => $fighter1,
                'fighter2_id' => $fighter2,
                'rounds' => $request->rounds,
                'start_date' => $request->start_date,
                ]);

        return json_encode($fight->toArray());
    }

    public function all()
    {
        $fights = Fight::all();
        return $this->formatFightDataToSend($fights);
    }

    public function makePrediction(Request $request)
    {
        $fight = Fight::find($request->fight_id);
        $predictionID = $request->predicion_id;
        $fight->makePrediction($predictionID);
        return $predictionID;
    }

    public function getPredictions(Request $request)
    {
        $fightID = $request->fight_id;
        $fight = Fight::find($fightID);
        if (!$fight) {
            return false;
        }
        $data = [];
        $data['predictions'] = $fight->allPredictions();
        $data['is_predicted'] = $fight->isPredicted();
        $data['prediction_id'] = $fight->predictionID();
        
        return json_encode($data);
    }

    public function getOldFights()
    {
        $fights = Auth::user()->predictedFights();
        return $this->formatFightDataToSend( $fights);
    }

    protected function formatFightDataToSend($fights)
    {
        $data = [];
        $i = 0;
        foreach ($fights as $fight) {
            if(!$fight->id){
                continue;
            }
            $data[$i]['fight_id'] = $fight->id;
            $data[$i]['fighter1'] = $fight->fighter1->name;
            $data[$i]['fighter2'] = $fight->fighter2->name;
            $data[$i]['start_date'] = $fight->start;
            $data[$i]['predicted'] = $fight->isPredicted();
            $i++;
        }
        return json_encode($data);
    }
}
