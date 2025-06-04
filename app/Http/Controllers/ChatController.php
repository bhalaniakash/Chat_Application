<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $messages = Message::where(function($query) use ($id) {
            $query->where('user_id', Auth::id())
                  ->where('recipient_id', $id);
        })->orWhere(function($query) use ($id) {
            $query->where('user_id', $id)
                  ->where('recipient_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('chat', compact('user', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'recipient_id' => 'required|exists:users,id'
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'message' => $request->message
        ]);

        // Broadcast to recipient
        broadcast(new MessageSent($message))->toOthers();
        
        // Broadcast to sender
        broadcast(new MessageSent($message));

        return response()->json([
            'message' => $message->message,
            'user_id' => Auth::id(),
            'created_at' => $message->created_at->format('H:i')
        ]);
    }
} 