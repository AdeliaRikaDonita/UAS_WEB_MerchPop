<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PhotoCard;
use App\Models\Store;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSellers = User::where('role', 'seller')->count();
        $totalBuyers = User::where('role', 'buyer')->count();
        $totalStores = Store::count();
        $totalProducts = PhotoCard::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->sum('total_amount');
        $recentOrders = Order::with('user')->latest()->take(8)->get();

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('d M');
            $chartData[] = (float) Order::whereIn('status', ['paid', 'processing', 'shipped', 'completed'])
                ->whereDate('created_at', $date->toDateString())
                ->sum('total_amount');
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSellers', 'totalBuyers', 'totalStores',
            'totalProducts', 'totalOrders', 'totalRevenue', 'recentOrders',
            'chartLabels', 'chartData'
        ));
    }
}
