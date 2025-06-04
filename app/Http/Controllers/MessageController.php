<?php
// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('user_id', Auth::id())
            ->orWhere('recipient_id', Auth::id())
            ->with(['sender', 'recipient'])
            ->latest()
            ->get();
            
        return view('messages.index', compact('messages'));
    }

    public function create()
    {
        try {
            $users = User::where('id', '!=', Auth::id())
                ->orderBy('name')
                ->get();
                
            if ($users->isEmpty()) {
                Log::warning('No users found in create message form');
            }
            
            return view('messages.create', ['users' => $users]);
        } catch (\Exception $e) {
            Log::error('Error in MessageController@create: ' . $e->getMessage());
            return redirect()->route('messages.index')
                ->with('error', 'Unable to load the message form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent!');
    }
}
