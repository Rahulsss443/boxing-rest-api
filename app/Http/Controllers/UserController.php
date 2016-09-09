<?php
 namespace App\Http\Controllers;

use App\Models\Fight;
use App\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{

    public function index(){
        return 'hello';
    }        
}
