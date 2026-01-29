<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'fullname' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'phone' => ['required','string','regex:/^(0|\+84)[0-9]{9,10}$/'],
            'address' => ['required','string'],
            'payment_method' => ['nullable','string'],
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->withErrors(['cart' => 'Giỏ hàng trống']);
        }

        $subtotal = 0;
        foreach ($cart as $c) { $subtotal += $c['price'] * $c['qty']; }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'fullname' => $data['fullname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'payment_method' => $data['payment_method'] ?? null,
                'subtotal' => $subtotal,
                'shipping' => 0,
                'total' => $subtotal,
                'status' => 'processing',
            ]);

            foreach ($cart as $c) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $c['id'] ?? null,
                    'name' => $c['name'],
                    'image' => $c['image'] ?? null,
                    'price' => $c['price'],
                    'qty' => $c['qty'],
                    'total' => $c['price'] * $c['qty'],
                ]);
            }

            DB::commit();
            // clear cart
            $request->session()->forget('cart');
            return redirect()->route('order.success', $order->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['order' => 'Không thể tạo đơn hàng: '.$e->getMessage()]);
        }
    }

    // Show order success page
    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('user.order-success', compact('order'));
    }

    // Show order detail to owner
    public function show(Request $request, $id)
    {
        $order = Order::with('items')->where('id', $id)->where('user_id', auth()->id())->first();
        if (! $order) {
            abort(404);
        }
        return view('user.order', ['order' => $order]);
    }

    // Demo pay action: mark order as paid
    public function pay(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->first();
        if (! $order) abort(404);
        $order->status = 'paid';
        $order->save();
        return redirect()->route('account.orders.show', $order->id)->with('status', 'Thanh toán thành công');
    }
}
