<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
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
                'read'     => $query->whereNotNull('read_at'),
                'unread'   => $query->whereNull('read_at'),
                'replied'  => $query->whereNotNull('replied_at'),
                default    => null,
            };
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = Message::where('profile_id', $profile->id)->whereNull('read_at')->count();

        return view('admin.messages.index', compact('messages', 'profile', 'unreadCount'));
    }

    public function show(Message $message)
    {
        $profile = $this->getProfile();

        if (is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
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
            'reply_text' => 'required|string',
        ]);

        $message->update([
            'reply_text'  => $validated['reply_text'],
            'replied_at'  => now(),
        ]);

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Reply sent successfully.');
    }

    public function markRead(Message $message)
    {
        if (is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Message marked as read.');
    }
}
