<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show cart (delegates to view)
    public function index()
    {
        return view('user.viewcart');
    }

    // Add an item to cart
    public function add(Request $request)
    {
        $data = $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'qty' => ['nullable', 'integer', 'min:1'],
            'image' => ['nullable', 'string'],
        ]);

        $id = (string) $data['id'];
        $qty = $data['qty'] ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $data['name'],
                'price' => floatval($data['price']),
                'qty' => $qty,
                'image' => $data['image'] ?? null,
            ];
        }

        session(['cart' => $cart]);

        // If AJAX/Fetch request, return JSON
        if ($request->wantsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'status' => 'success',
                'message' => 'Đã thêm vào giỏ hàng',
                'cart_count' => array_sum(array_column($cart, 'qty')),
            ]);
        }

        return back()->with('status', 'Đã thêm vào giỏ hàng');
    }

    // Update item quantity
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => ['required'],
            'qty' => ['required', 'integer', 'min:0'],
        ]);

        $id = (string) $data['id'];
        $qty = (int) $data['qty'];

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $qty;
            }
            session(['cart' => $cart]);
        }

        return back()->with('status', 'Giỏ hàng đã được cập nhật');
    }

    // Remove item
    public function remove(Request $request)
    {
        $data = $request->validate(['id' => ['required']]);
        $id = (string) $data['id'];
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return back()->with('status', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }

    // Clear cart
    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return back()->with('status', 'Giỏ hàng đã được xóa');
    }

    // Helpful route to add a sample item for testing
    public function addSample()
    {
        $sample = [
            'id' => 'sample-1',
            'name' => 'Sample Product',
            'price' => 49.99,
            'qty' => 1,
        ];
        $cart = session()->get('cart', []);
        $id = $sample['id'];
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = $sample;
        }
        session(['cart' => $cart]);
        return back()->with('status', 'Đã thêm sản phẩm mẫu vào giỏ hàng');
    }
}
