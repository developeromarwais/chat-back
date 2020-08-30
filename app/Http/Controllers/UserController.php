<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Pusher\Pusher;


class UserController extends Controller
{
    //
    public function index()
    {
        $users = DB::table('users')->where('id', "!=", Auth::id())->get();
        return $users;
    }
}
