<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    public function index($id)
    {
        $messages = DB::table('messages')
            ->where([['sender_id', Auth::id()],  ['receiver_id', $id]])
            ->orWhere([['sender_id', $id],  ['receiver_id', Auth::id()]])
            ->get();
        return $messages;
    }

    public function show(Message $message)
    {
        return $message;
    }

    public function store(Request $request)
    {
        $message = Message::create($request->all());
        event(new SendMessage($request->content));
        return response()->json($message, 201);
    }
}
