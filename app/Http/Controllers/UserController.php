<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Pusher\Pusher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['userId'] = $user->id;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    //
    public function index()
    {
        $users = DB::table('users')->where('id', "!=", Auth::id())->get();
        return $users;
    }

    public function pusherAuth(Request $request)
    {

        $user = auth()->user();
        if ($user) {
            $pusher = new Pusher('31386b6513308fa6b50b', '00cb1a42a3221334d5a3', '1060430');
            // $auth = $pusher->presence_auth($request->channel_name, $request->socket_id, $user->id);
            // header('Content-Type: application/json');
            // echo $auth;
            // return;
            $presenceData = ['id' => Auth::user()->id];

            echo $pusher->presence_auth($request->channel_name, $request->socket_id, $user->id, $presenceData);
        } else {
            header('', true, 403);
            echo "Forbidden";
            return;
        }
    }

    public function pusherAuthChat(Request $request)
    {

        $user = auth()->user();
        if ($user) {
            $pusher = new Pusher('31386b6513308fa6b50b', '00cb1a42a3221334d5a3', '1060430');
            $auth = $pusher->socket_auth($request->channel_name, $request->socket_id);
            header('Content-Type: application/json');
            echo $auth;
            return;
        } else {
            header('', true, 403);
            echo "Forbidden";
            return;
        }
    }
}
