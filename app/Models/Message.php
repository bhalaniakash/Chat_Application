<?php
// app/Models/Message.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'recipient_id', 'message', 'attachment'
    ];

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the recipient of the message.
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Get the user who sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the full URL for the attachment.
     */
    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    /**
     * Scope a query to only include messages between two users.
     */
    public function scopeBetweenUsers(Builder $query, $user1Id, $user2Id)
    {
        return $query->where(function ($query) use ($user1Id, $user2Id) {
            $query->where('user_id', $user1Id)
                  ->where('recipient_id', $user2Id);
        })->orWhere(function ($query) use ($user1Id, $user2Id) {
            $query->where('user_id', $user2Id)
                  ->where('recipient_id', $user1Id);
        });
    }

    /**
     * Scope a query to only include messages for a specific user.
     */
    public function scopeForUser(Builder $query, $userId)
    {
        return $query->where('user_id', $userId)
                    ->orWhere('recipient_id', $userId);
    }

    /**
     * Scope a query to only include unread messages.
     */
    public function scopeUnread(Builder $query)
    {
        return $query->where('read_at', null);
    }

    /**
     * Mark the message as read.
     */
    public function markAsRead()
    {
        if (!$this->read_at) {
            $this->read_at = now();
            $this->save();
        }
    }

    /**
     * Check if the message is unread.
     */
    public function isUnread()
    {
        return $this->read_at === null;
    }
}
