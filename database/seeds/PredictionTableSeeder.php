<?php
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
//use DB;

class PredictionTableSeeder extends Seeder
{
    public function run()
    {
        //DB::table('predictions')->truncate();
        DB::table('predictions')->insert([
            [
                'name' => 'fighter1-on-points',
                'display_name' => 'on Points'
            ],
            [
                'name' => 'fighter1-distance',
                'display_name' => 'inside the distance'
            ],
            [
                'name' => 'draw',
                'display_name' => 'Draw'
            ],
            [
                'name' => 'fighter2-on-points',
                'display_name' => 'on Points'
            ],
            [
                'name' => 'fighter2-distance',
                'display_name' => 'inside the distance'
            ],

        ]);
    }
}
