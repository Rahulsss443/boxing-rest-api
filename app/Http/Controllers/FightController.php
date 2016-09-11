<?php
 namespace App\Http\Controllers;

use App\Models\Fight;
use App\Models\FightResult;
use App\Models\Fighter;
use App\Models\Outcome;
use Auth;
use Illuminate\Http\Request;

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
        $fights = Fight::formalFights();
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

    public function allFormalFightWithScores() 
    {
        $fights = Fight::formalFights();
        return ($fights) ? $this->setupFightScoreDataToSend($fights):[];  
    }

    protected function setupFightScoreDataToSend($fights)
    {
        $data = [];
        $i = 0;
        foreach ($fights as $fight) {
            if(!$fight->id){
                continue;
            }
            $data[$i]['fight_id'] = $fight->id;
            $data[$i]['fighter1'] = [ 'name' => $fight->fighter1->name, 'id' => $fight->fighter1->id ];
            $data[$i]['fighter2'] = [ 'name' => $fight->fighter2->name, 'id' => $fight->fighter2->id ];
            $data[$i]['start_date'] = $fight->start;
            $data[$i]['scores'] = $fight->scores();

            $i++;
        }
        return json_encode($data);
    }

    public function allCustomeFightWithScores()
    {
        $fights = Fight::customeFights();
        return ($fights) ? $this->setupFightScoreDataToSend($fights):[];
    }

    public function storeRoundScore(Request $request){
        $data = [];
        $data['fight_id'] = $request->fight_id;
        $data['user_id'] = Auth::user()->id;
        $score_fighter1 = (int)$request->score_fighter1;
        $score_fighter2 = (int)$request->score_fighter2;
        $roundNo =  (int) $request->round_no;
        $outcomeID = $request->outcome_id;
        $winnerID = $request->winner_id;
        $outcome = Outcome::find($outcomeID);
        $winner = Fighter::find($winnerID);
        if($outcome && $winner) {
           FightResult::where($data)->update(['outcome_id'=>0, 'winner'=> 0]);
           $score_fighter1 = 0; 
           $score_fighter2 = 0; 
        } else {
        $winnerID = 0;
        $outcome = 0;
        }
         $data['round_no'] = $roundNo;
         $result = FightResult::where($data)->first();


        $data['fighter1_score'] = $score_fighter1;
        $data['fighter2_score'] = $score_fighter2;
        $data['outcome_id'] = $outcomeID;
        $data['winner'] = $winnerID;
       
        if($result) {
            $result->update($data);
        } else {
                  FightResult::firstOrCreate($data);
        }
        return $this->fightwithScore($data['fight_id']);
    }

    public function getOutcomes()
    {
        $outcomes = Outcome::all();
        $i =0;
        $data = [];
        foreach ($outcomes as $outcome) {
           $data[$i]['id'] =$outcome->id; 
           $data[$i]['abbr'] =$outcome->abbr; 
           $i++;
        }
        return json_encode($data);
    }

    public function fightWithScore($fightID) {
      $fight = Fight::find($fightID);
      $data = [];
      $data['score'] = $fight->getScore();
      $data['final_score'] = $fight->scores();
      $data['fight_id'] = $fightID;
      $data['fighters'] = [
              'fighter1' =>[ 'name' => $fight->fighter1->name, 'id' => $fight->fighter1->id ],
              'fighter2' => [ 'name' => $fight->fighter2->name, 'id' => $fight->fighter2->id ],
      ];
      return json_encode($data);   
    }
}
