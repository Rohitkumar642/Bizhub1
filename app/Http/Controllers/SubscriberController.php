<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Mail\SubscriberMail;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = Subscriber::where('email', $request->email)->first();

        if ($subscriber) {
            // Update the existing record to "subscribed"
            $subscriber->status = 'subscribed';
            $subscriber->save();
            Mail::to($request->email)->send(new SubscriberMail($request->all()));
            return response()->json(['message' => 'Subscription updated successfully!']);
        } else {
            // Insert a new record
            Subscriber::create([
                'email' => $request->email,
                'status' => 'subscribed'
            ]);

            Mail::to($request->email)->send(new SubscriberMail($request->all()));

            return response()->json(['message' => 'Subscribed successfully!']);
        }
    }

    public function unsubscribe(Request $request)
{
    $email = $request->email;

    $subscriber = Subscriber::where('email', $email)->first();
    if (!$subscriber) {
        return response()->json(['message' => 'Email not found!'], 404);
    }

    $subscriber->status = 'unsubscribed';
    $subscriber->save();

    return response()->json(['message' => 'You have been unsubscribed successfully.']);
}

public function delete($email)
    {
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            $subscriber->status = 'unsubscribed'; // Update status
            $subscriber->save();

            return response()->json([
                'message' => 'You have been unsubscribed successfully.'
            ]);
        }

        return response()->json([
            'message' => 'Subscriber not found.'
        ], 404);
    }

}
