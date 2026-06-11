<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Expense;
use App\Models\Itinerary;
use App\Models\Packinglist;
use App\Models\Destination;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // ==========================================
    // TRIPS
    // ==========================================
    public function tripsIndex()
    {
        $trips = Trip::where('user_id', auth()->id())->orderBy('start_date', 'asc')->get();
        return view('frontend.trips', compact('trips'));
    }

    public function destroyTrip(Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) abort(403);
        $trip->delete();
        return redirect()->back()->with('success', 'Trip berhasil dihapus!');
    }

    public function updateTrip(Request $request, Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) abort(403);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'country_or_city' => 'required|string|max:255',
            'start_date' => 'required|date',
            'pax_count' => 'required|integer|min:1',
        ]);
        $trip->update($validated);
        return redirect()->back()->with('success', 'Trip berhasil diperbarui!');
    }

    // ==========================================
    // EXPENSES
    // ==========================================
    public function expensesIndex(Request $request)
    {
        $allTrips = Trip::where('user_id', auth()->id())->orderBy('title', 'asc')->get();
        $selectedTripId = $request->query('trip_id', $allTrips->first()->id ?? null);
        
        $expenses = collect();
        if ($selectedTripId) {
            $expenses = Expense::where('trip_id', $selectedTripId)->get();
        }

        return view('frontend.expenses', compact('allTrips', 'expenses', 'selectedTripId'));
    }

    public function updateExpense(Request $request, Expense $expense)
    {
        if ($expense->trip->user_id !== auth()->id()) abort(403);
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'expense_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        $expense->update($validated);
        return redirect()->back()->with('success', 'Pengeluaran diperbarui!');
    }

    public function destroyExpense(Expense $expense)
    {
        if ($expense->trip->user_id !== auth()->id()) abort(403);
        $expense->delete();
        return redirect()->back()->with('success', 'Pengeluaran dihapus!');
    }

    // ==========================================
    // ITINERARIES
    // ==========================================
    public function itinerariesIndex(Request $request)
    {
        $allTrips = Trip::where('user_id', auth()->id())->orderBy('title', 'asc')->get();
        $selectedTripId = $request->query('trip_id', $allTrips->first()->id ?? null);
        
        $itineraries = collect();
        if ($selectedTripId) {
            $itineraries = Itinerary::where('trip_id', $selectedTripId)->orderBy('day_number')->orderBy('start_time')->get();
        }

        return view('frontend.itineraries', compact('allTrips', 'itineraries', 'selectedTripId'));
    }

    public function updateItinerary(Request $request, Itinerary $itinerary)
    {
        if ($itinerary->trip->user_id !== auth()->id()) abort(403);
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'day_number' => 'required|integer|min:1',
            'start_time' => 'required',
            'activity' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $itinerary->update($validated);
        return redirect()->back()->with('success', 'Itinerary diperbarui!');
    }

    public function destroyItinerary(Itinerary $itinerary)
    {
        if ($itinerary->trip->user_id !== auth()->id()) abort(403);
        $itinerary->delete();
        return redirect()->back()->with('success', 'Itinerary dihapus!');
    }

    // ==========================================
    // PACKINGLISTS
    // ==========================================
    public function packinglistsIndex(Request $request)
    {
        $allTrips = Trip::where('user_id', auth()->id())->orderBy('title', 'asc')->get();
        $selectedTripId = $request->query('trip_id', $allTrips->first()->id ?? null);
        
        $packinglists = collect();
        if ($selectedTripId) {
            $packinglists = Packinglist::where('trip_id', $selectedTripId)->get();
        }

        return view('frontend.packinglists', compact('allTrips', 'packinglists', 'selectedTripId'));
    }

    public function updatePackinglist(Request $request, Packinglist $packinglist)
    {
        if ($packinglist->trip->user_id !== auth()->id()) abort(403);
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'item_name' => 'required|string|max:255',
            'is_checked' => 'nullable|boolean',
        ]);
        $validated['is_checked'] = $request->has('is_checked');
        $packinglist->update($validated);
        return redirect()->back()->with('success', 'Checklist diperbarui!');
    }

    public function togglePackinglist(Request $request, Packinglist $packinglist)
    {
        if ($packinglist->trip->user_id !== auth()->id()) abort(403);
        $packinglist->update(['is_checked' => !$packinglist->is_checked]);
        return redirect()->back();
    }

    public function destroyPackinglist(Packinglist $packinglist)
    {
        if ($packinglist->trip->user_id !== auth()->id()) abort(403);
        $packinglist->delete();
        return redirect()->back()->with('success', 'Checklist dihapus!');
    }

    // ==========================================
    // DESTINATIONS
    // ==========================================
    public function destinationsIndex(Request $request)
    {
        $allTrips = Trip::where('user_id', auth()->id())->orderBy('title', 'asc')->get();
        $selectedTripId = $request->query('trip_id', $allTrips->first()->id ?? null);
        
        $destinations = collect();
        if ($selectedTripId) {
            $destinations = Destination::where('trip_id', $selectedTripId)->orderBy('visit_date', 'asc')->get();
        }

        return view('frontend.destinations', compact('allTrips', 'destinations', 'selectedTripId'));
    }

    public function updateDestination(Request $request, Destination $destination)
    {
        if ($destination->trip->user_id !== auth()->id()) abort(403);
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'name' => 'required|string|max:255',
            'visit_date' => 'nullable|date',
        ]);
        $destination->update($validated);
        return redirect()->back()->with('success', 'Destinasi diperbarui!');
    }

    public function destroyDestination(Destination $destination)
    {
        if ($destination->trip->user_id !== auth()->id()) abort(403);
        $destination->delete();
        return redirect()->back()->with('success', 'Destinasi dihapus!');
    }
}
