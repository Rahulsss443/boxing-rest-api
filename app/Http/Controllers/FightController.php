<?php
 namespace App\Http\Controllers;

use App\Models\Fight;
use App\Models\Fighter;
use Illuminate\Http\Request;

class FightController extends Controller
{

    public function create(Request $request)
    {
        $fighter1 = Fighter::firstOrCreate (['name' => $request->fighter1 ])->id;
        $fighter2 = Fighter::firstOrCreate (['name' => $request->fighter2 ])->id;
        
        $fight = Fight::firstOrCreate ([
                'fighter1_id' => $fighter1,
                'fighter2_id' => $fighter2,
                'rounds' => $request->rounds,
                //'start_date' => $request->start_date,
                ]);

        return json_encode($fight->toArray());
    }
}
