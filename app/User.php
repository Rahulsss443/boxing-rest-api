<?php

namespace App;

use App\Models\Fight;
use App\Models\UserPrediction;
use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function old_predictions(){
        return $this->hasMany(UserPrediction::class);
    }

    public function predictedFights()
    {
         $predictions = $this->old_predictions;
         $fightIDs = [];
         foreach ($predictions as $prediction) {
           $fightIDs[] = $prediction->fight_id;
         }

         return Fight::whereIn('id', $fightIDs)->get();
    }
}
