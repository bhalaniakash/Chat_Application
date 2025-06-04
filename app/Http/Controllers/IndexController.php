<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Events\MessageSent;

class IndexController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('dashboard', compact('users'));
    }

    public function chat($id)
    {
        $user = User::findOrFail($id);
        $messages = Message::where(function($query) use ($id) {
            $query->where('user_id', auth()->id())
                  ->where('recipient_id', $id);
        })->orWhere(function($query) use ($id) {
            $query->where('user_id', $id)
                  ->where('recipient_id', auth()->id());
        })->orderBy('created_at')->get();
        // If AJAX request, return only the chat box HTML
        if (request()->ajax()) {
            return response()->view('chat', compact('user', 'messages'));
        }
        return view('chat', compact('user', 'messages'));
    }

    public function storeMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $message = new Message();
        $message->user_id = auth()->id();
        $message->recipient_id = $id;
        $message->message = $request->input('message');
        $message->save();
        $message->load('user');
        broadcast(new MessageSent($message, $message->recipient_id))->toOthers();
        // Return only the message data for AJAX
        return response()->json([
            'id' => $message->id,
            'user_id' => $message->user_id,
            'recipient_id' => $message->recipient_id,
            'message' => $message->message,
            'created_at' => $message->created_at->format('H:i'),
            'user_name' => $message->user->name ?? 'User',
        ]);
    }
}
