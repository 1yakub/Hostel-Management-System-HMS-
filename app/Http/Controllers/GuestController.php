<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::all();
        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        return view('guests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'id_number' => 'required|string|max:50|unique:guests'
        ]);

        Guest::create($validated);
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

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'id_number' => 'required|string|max:50|unique:guests,id_number,' . $guest->id,
        ]);

        $guest->update($validated);
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
