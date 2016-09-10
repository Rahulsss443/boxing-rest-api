<?php
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
//use DB;

class OutcomeTableSeeder extends Seeder
{
    public function run()
    {
       
        DB::table('outcomes')->insert([
            [
                'abbr' => 'RTD',
                'name' => 'Retired',
                'description' => 'Fighter or their corner withdraw from the match and loses the fight.',
            ],
            [
                'abbr' => 'KO',
                'name' => 'Knockout',
                'description' => 'Fighter does not get up from knockdown after a 10 count from the referee and loses the fight.',
            ],
             [
                'abbr' => 'TKO',
                'name' => 'Technical Knockout',
                'description' => 'Referee steps in because he feels fighter is unable to continue and loses the fight.',
            ],            
            [
                'abbr' => 'TD',
                'name' => 'Technical Decision',
                'description' => 'Referee, doctor , physician stops the fight normally due to injury. '
            ],
            [
                'abbr' => 'DQ',
                'name' => 'Disqualified',
                'description' => ''
            ],
            [
                'abbr' => 'NC',
                'name' => 'No Contest',
                'description' => ' '
            ],
             [
                'abbr' => 'COT',
                'name' => 'Clear OutCome',
                'description' => ' '
            ],

        ]);
    }
}
