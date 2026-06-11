<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Destination;
use App\Models\Expense;
use App\Models\Itinerary;
use App\Models\Packinglist;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Stats
        $totalTrips = Trip::where('user_id', $userId)->count();
        $activeTrips = Trip::where('user_id', $userId)
                           ->where('start_date', '>=', now()->toDateString())
                           ->count();
        $tripIds = Trip::where('user_id', $userId)->pluck('id');
        $destinationsWishlist = Destination::whereIn('trip_id', $tripIds)->count();
        // Progress Persiapan (Based on Packinglist)
        // Kita butuh packinglist dari trip milik user
        $totalPacking = Packinglist::whereIn('trip_id', $tripIds)->count();
        $checkedPacking = Packinglist::whereIn('trip_id', $tripIds)->where('is_checked', true)->count();
        $progressPersiapan = $totalPacking > 0 ? round(($checkedPacking / $totalPacking) * 100) : 0;

        // 2. Nearest Trip
        $nearestTrip = Trip::where('user_id', $userId)
                           ->where('start_date', '>=', now()->toDateString())
                           ->orderBy('start_date', 'asc')
                           ->first();

        // 3. Estimasi Budget (Group by expense_name to power the chart)
        $expenses = collect();
        $totalBudget = 0;
        $packingLists = collect();
        $itineraries = collect();

        if ($nearestTrip) {
            $expenses = Expense::where('trip_id', $nearestTrip->id)
                                ->selectRaw('expense_name, sum(amount) as total_amount')
                                ->groupBy('expense_name')
                                ->get();
            $totalBudget = $expenses->sum('total_amount');

            // 4. Itinerary Ringkas for nearest trip
            $itineraries = Itinerary::with('destination')
                ->where('trip_id', $nearestTrip->id)
                ->orderBy('day_number', 'asc')
                ->orderBy('start_time', 'asc')
                ->get()
                ->groupBy('day_number');

            // 5. Checklist Persiapan (From packinglist of nearest trip)
            $packingLists = Packinglist::where('trip_id', $nearestTrip->id)
                                       ->orderBy('is_checked', 'asc')
                                       ->take(4)
                                       ->get();
        }

        $destinations = collect();
        if ($nearestTrip) {
            // 6. Wishlist Destinasi untuk trip terdekat
            $destinations = Destination::where('trip_id', $nearestTrip->id)->take(6)->get();
        }

        // 7. Get all trips for dropdowns
        $allTrips = Trip::where('user_id', $userId)->orderBy('title', 'asc')->get();

        return view('dashboard.index', compact(
            'totalTrips',
            'activeTrips',
            'destinationsWishlist',
            'progressPersiapan',
            'nearestTrip',
            'expenses',
            'totalBudget',
            'itineraries',
            'packingLists',
            'destinations',
            'allTrips'
        ));
    }

    public function storeTrip(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'country_or_city' => 'required|string|max:255',
            'start_date' => 'required|date',
            'pax_count' => 'required|integer|min:1',
        ]);

        $validated['user_id'] = auth()->id();
        Trip::create($validated);

        return redirect()->back()->with('success', 'Trip berhasil dibuat!');
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'expense_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Security check
        $trip = Trip::where('id', $validated['trip_id'])->where('user_id', auth()->id())->firstOrFail();

        Expense::create($validated);
        return redirect()->back()->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function storeItinerary(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'day_number' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'activity' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $trip = Trip::where('id', $validated['trip_id'])->where('user_id', auth()->id())->firstOrFail();

        Itinerary::create($validated);
        return redirect()->back()->with('success', 'Jadwal perjalanan berhasil ditambahkan!');
    }

    public function storePackinglist(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'item_name' => 'required|string|max:255',
        ]);

        $trip = Trip::where('id', $validated['trip_id'])->where('user_id', auth()->id())->firstOrFail();

        Packinglist::create($validated);
        return redirect()->back()->with('success', 'Checklist berhasil ditambahkan!');
    }

    public function storeDestination(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'name' => 'required|string|max:255',
            'visit_date' => 'nullable|date',
        ]);

        $trip = Trip::where('id', $validated['trip_id'])->where('user_id', auth()->id())->firstOrFail();

        Destination::create($validated);
        return redirect()->back()->with('success', 'Destinasi berhasil ditambahkan!');
    }
}
