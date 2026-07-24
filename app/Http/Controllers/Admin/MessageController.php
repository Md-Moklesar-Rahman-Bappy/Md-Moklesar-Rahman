<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends AdminController
{
    public function index(Request $request)
    {
        $profile = $this->getProfile();

        $query = Message::where('profile_id', $profile->id);

        if ($request->filled('filter')) {
            match ($request->filter) {
                'read' => $query->where('is_read', true),
                'unread' => $query->where('is_read', false),
                'replied' => $query->whereNotNull('replied_at'),
                default => null,
            };
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = Message::where('profile_id', $profile->id)->where('is_read', false)->count();

        return view('admin.messages.index', compact('messages', 'profile', 'unreadCount'));
    }

    public function show(Message $message)
    {
        $profile = $this->getProfile();

        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message', 'profile'));
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function reply(Request $request, Message $message)
    {
        $validated = $request->validate([
            'reply' => 'required|string',
        ]);

        $message->update([
            'reply' => $validated['reply'],
            'replied_at' => now(),
            'is_read' => true,
        ]);

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Reply saved successfully.');
    }

    public function markRead(Message $message)
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Message marked as read.');
    }
}
