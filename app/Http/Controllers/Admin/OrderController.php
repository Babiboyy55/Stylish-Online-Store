<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
    }

    public function approve(Order $order)
    {
        // Chỉ phê duyệt đơn hàng đang chờ xử lý
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Chỉ có thể phê duyệt đơn hàng đang chờ xử lý!');
        }

        $order->update(['status' => 'processing']);

        return redirect()->back()->with('success', 'Đơn hàng đã được phê duyệt và chuyển sang trạng thái đang xử lý!');
    }

    public function reject(Order $order)
    {
        // Chỉ từ chối đơn hàng đang chờ xử lý hoặc đang xử lý
        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Không thể từ chối đơn hàng đã gửi hoặc đã giao!');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Đơn hàng đã bị từ chối!');
    }
}
