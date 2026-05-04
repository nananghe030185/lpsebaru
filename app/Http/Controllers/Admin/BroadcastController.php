<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\BroadcastModel;
use App\Models\Outbox;
use App\Models\User;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.broadcast.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BroadcastModel $broadcastModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BroadcastModel $broadcastModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BroadcastModel $broadcastModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BroadcastModel $broadcastModel)
    {
        //
    }

    public function member()
    {
        return view('admin.broadcast.member');
    }

    public function email()
    {
        return view('admin.broadcast.email');
    }

    public function whatsapp()
    {
        return view('admin.broadcast.whatsapp');
    }

    public function telegram()
    {
        $member = User::where('group_id', 2)->count();
        $nonmember = User::where('group_id', 3)->count();
        $semua = User::where('group_id', 3)->OrWhere('group_id', 2)->count();
        return view('admin.broadcast.telegram', compact('member', 'nonmember', 'semua'));
    }

    public function sendOutbox($value, $message)
    {
        Outbox::create([
            'status' => false,
            'recipient' => $value->telegram,
            'message' => $message,
            'channel' => 'telegram',
        ]);
    }

    public function telegrammember(Request $request)
    {
        $user = User::where('group_id', 2)->whereNotNull('telegram')->get();
        //

        $request->validate([
            'message' => 'required|string',
        ]);
        
        foreach ($user as $key => $value) {
            $this->sendOutbox($value, $request->message);
        }

        return redirect()->back()->with('success', 'Broadcast Telegram Member berhasil dikirim ke Outbox.');
    }

    public function telegramnonmember(Request $request)
    {
        $user = User::where('group_id', 1)->whereNotNull('telegram')->get();
        //

        $request->validate([
            'message' => 'required|string',
        ]);
        
        foreach ($user as $key => $value) {
            $this->sendOutbox($value, $request->message);
        }

        return redirect()->back()->with('success', 'Broadcast Telegram Member berhasil dikirim ke Outbox.');
    }

    public function telegramsemua(Request $request)
    {
        $user = User::where('group_id', 2)->orWhere('group_id', 1)->whereNotNull('telegram')->get();
        //

        $request->validate([
            'message' => 'required|string',
        ]);
        
        foreach ($user as $key => $value) {
            $this->sendOutbox($value, $request->message);
        }

        return redirect()->back()->with('success', 'Broadcast Telegram Member berhasil dikirim ke Outbox.');
    }

    public function telegramouter(Request $request)
    {
        //
    }
}
