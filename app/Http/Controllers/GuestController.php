<?php

namespace App\Http\Controllers;

use App\Http\Requests\Desk\GuestRequest;
use App\Models\Guest;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Guest::class, 'guest');
    }

    public function index()
    {
        return view('guests.index', ['guests' => Guest::all()]);
    }

    public function create()
    {
        return view('guests.create');
    }

    public function store(GuestRequest $request)
    {
        Guest::create($request->validated());

        return redirect()->route('guests.index')->with('success', 'Guest registered successfully');
    }

    public function show(Guest $guest)
    {
        $guest->load(['bookings.room']);

        return view('guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(GuestRequest $request, Guest $guest)
    {
        $guest->update($request->validated());

        return redirect()->route('guests.show', $guest)->with('success', 'Guest updated successfully');
    }

    public function destroy(Guest $guest)
    {
        if ($guest->bookings()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete guest with active bookings');
        }

        $guest->delete();

        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully');
    }
}
