<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NewsletterController extends AdminController
{
    public function index()
    {
        $profile = $this->getProfile();

        $subscribers = Subscriber::where('profile_id', $profile->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.newsletter.index', compact('subscribers', 'profile'));
    }

    public function export()
    {
        $profile = $this->getProfile();

        $subscribers = Subscriber::where('profile_id', $profile->id)
            ->where('is_active', true)
            ->orderBy('email')
            ->get();

        $csvContent = "Email,Name,Subscribed At\n";

        foreach ($subscribers as $subscriber) {
            $csvContent .= sprintf(
                "%s,%s,%s\n",
                $subscriber->email,
                $subscriber->name ?? '',
                $subscriber->created_at->format('Y-m-d H:i:s')
            );
        }

        return Response::make($csvContent, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscribers-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.newsletter.index')
            ->with('success', 'Subscriber deleted successfully.');
    }
}
