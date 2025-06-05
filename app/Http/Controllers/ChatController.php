<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        'message' => 'required_without:attachment|string|max:1000',
        'recipient_id' => 'required|exists:users,id',
        'attachment' => 'nullable|file|max:10240' // Max 10MB
    ]);

    // Debugging - check if file is received
    if ($request->hasFile('attachment')) {
        \Log::info('File received: ' . $request->file('attachment')->getClientOriginalName());
    } else {
        \Log::info('No file received in request');
    }

    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $attachmentPath = $file->storeAs('attachments', $fileName, 'public');
        \Log::info('File stored at: ' . $attachmentPath);
    }

    $message = Message::create([
        'user_id' => Auth::id(),
        'recipient_id' => $request->recipient_id,
        'message' => $request->message ?? '',
        'attachment' => $attachmentPath
    ]);

    \Log::info('Message created with attachment path: ' . $message->attachment);

    // Broadcast to recipient
    // broadcast(new MessageSent($message))->toOthers();
    
    // // Broadcast to sender
    // broadcast(new MessageSent($message));

    // return response()->json([
    //     'message' => $message->message,
    //     'user_id' => Auth::id(),
    //     'created_at' => $message->created_at->format('H:i'),
    //     'attachment' => $attachmentPath ? Storage::url($attachmentPath) : null
    // ]);
}
} 