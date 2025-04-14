<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function afficherNotifications()
   {
    $notifications = Notification::where('userId', auth()->id())
                                  ->orderBy('created_at', 'desc')
                                  ->get();

    return view('notifications.index', compact('notifications'));
   }
   public function marquerCommeLue($id)
{
    $notification = Notification::findOrFail($id);
    $notification->dateLecture = now(); // Marquer la notification comme lue
    $notification->save();

    return redirect()->back()->with('success', 'Notification marquée comme lue.');
}

}
