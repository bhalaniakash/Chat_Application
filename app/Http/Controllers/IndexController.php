<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

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
        $message->message = $request->input('message'); // Use 'message' column
        $message->save();
        return redirect()->route('chat.view', ['id' => $id]);
    }
}
