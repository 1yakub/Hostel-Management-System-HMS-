<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Guest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        // Calculate monthly revenue
        $currentMonthRevenue = Booking::whereMonth('created_at', $thisMonth->month)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $lastMonthRevenue = Booking::whereMonth('created_at', $lastMonth->month)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        // Calculate revenue growth
        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 0;

        // Calculate occupancy rate
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        $stats = [
            'totalRooms' => $totalRooms,
            'availableRooms' => Room::where('status', 'available')->count(),
            'occupiedRooms' => $occupiedRooms,
            'maintenanceRooms' => Room::where('status', 'maintenance')->count(),
            'activeBookings' => Booking::where('status', 'active')->count(),
            'totalGuests' => Guest::count(),
            'monthlyRevenue' => $currentMonthRevenue,
            'revenueGrowth' => $revenueGrowth,
            'occupancyRate' => $occupancyRate,
            'newGuestsThisMonth' => Guest::whereMonth('created_at', $thisMonth->month)->count(),
            'checkoutsToday' => Booking::where('check_out_date', $today)->where('status', 'active')->count(),
            'checkinsToday' => Booking::where('check_in_date', $today)->where('status', 'active')->count(),
        ];

        $recentBookings = Booking::with(['room', 'guest'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($booking) {
                $booking->status_color = match ($booking->status) {
                    'active' => 'green',
                    'pending' => 'yellow',
                    'completed' => 'gray',
                    'cancelled' => 'red',
                    default => 'gray'
                };
                return $booking;
            });

        return view('dashboard', compact('stats', 'recentBookings'));
    }
}
