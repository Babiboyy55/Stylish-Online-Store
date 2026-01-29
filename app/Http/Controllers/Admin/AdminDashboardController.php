<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $stats = [
            'total_customers' => User::where('is_admin', 0)->count(),
            'total_revenue_this_month' => Order::whereMonth('created_at', now()->month)
                                              ->whereYear('created_at', now()->year)
                                              ->sum('total'),
            'total_orders_this_month' => Order::whereMonth('created_at', now()->month)
                                             ->whereYear('created_at', now()->year)
                                             ->count(),
            'total_products' => Product::count(),
        ];

        // Lấy đơn hàng gần đây (10 đơn mới nhất)
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Doanh thu theo tháng (6 tháng gần nhất)
        // Use DB-specific date formatting: SQLite doesn't support DATE_FORMAT
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            $dateExpr = "strftime('%Y-%m', created_at)";
        } else {
            // MySQL, MariaDB and others support DATE_FORMAT
            $dateExpr = "DATE_FORMAT(created_at, '%Y-%m')";
        }

        $monthlyRevenue = Order::select(
                DB::raw("{$dateExpr} as month"),
                DB::raw('SUM(total) as revenue')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Top 5 sản phẩm bán chạy
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.qty) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'monthlyRevenue', 'topProducts'));
    }
}
