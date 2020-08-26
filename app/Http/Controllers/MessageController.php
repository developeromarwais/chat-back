<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    public function index()
    {
        return Message::all();
    }

    public function show(Message $message)
    {
        return $message;
    }

    public function store(Request $request)
    {
        $message = Message::create($request->all());
        
        return response()->json($message, 201);
    }
}
