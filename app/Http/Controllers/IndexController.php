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
            'message' => 'required_without:attachment|string|nullable',
            'attachment' => 'nullable|file|max:10240', // max 10MB
        ]);

        $message = new Message();
        $message->user_id = auth()->id();
        $message->recipient_id = $id;
        $message->message = $request->input('message');

        // Handle attachment upload
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $message->attachment = $path;
        }

        $message->save();
        $message->load('user');
        broadcast(new MessageSent($message, $message->recipient_id))->toOthers();

        // Return message data for AJAX
        return response()->json([
            'id' => $message->id,
            'user_id' => $message->user_id,
            'recipient_id' => $message->recipient_id,
            'message' => $message->message,
            'attachment' => $message->attachment ?? null,
            'created_at' => $message->created_at->format('H:i'),
            'user_name' => $message->user->name ?? 'User',
        ]);
    }
}
