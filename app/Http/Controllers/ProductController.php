<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    // List products (DB-driven)
    public function index()
    {
        // show only active products if the column exists, else fallback to all
        $query = Product::query();
        try {
            if (Schema::hasColumn('products', 'is_active')) {
                $query->where('is_active', 1);
            }
        } catch (\Throwable $e) {
            // ignore schema check errors on some environments
        }

        $products = $query->orderBy('created_at', 'desc')->get();
        return view('user.index', compact('products'));
    }

    // Show sale products (products with sale_price)
    public function sale()
    {
        $query = Product::query();

        // Only active products
        try {
            if (Schema::hasColumn('products', 'is_active')) {
                $query->where('is_active', 1);
            }
        } catch (\Throwable $e) {
            // ignore schema check errors
        }

        // Only products with sale_price
        $products = $query->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.sale', compact('products'));
    }

    // Show single product
    public function show(Request $request, $id)
    {
        // support lookup by numeric id, slug, or sku (legacy p1..p10)
        $product = null;

        // look by id if numeric
        if (is_numeric($id)) {
            $product = Product::find($id);
        }

        // fallback to slug or sku
        if (! $product) {
            $product = Product::where('slug', $id)->orWhere('sku', $id)->first();
        }

        if (! $product) {
            // support demo pages for static category templates (men-1, women-2, ...)
            if (is_string($id) && preg_match('/^(men|women)-(\d+)$/', $id, $m)) {
                $gender = $m[1];
                $num = (int) $m[2];
                $name = $gender === 'men' ? "Sản phẩm nam $num" : "Sản phẩm nữ $num";
                $price = $gender === 'men' ? 99 : 89;
                $imageIndex = ($num % 10) + 1;

                $demo = [
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'image' => "user/images/card-item{$imageIndex}.jpg",
                    'description' => "Mô tả demo cho {$name}",
                ];

                return view('user.product', ['product' => $demo]);
            }

            abort(404);
        }

        return view('user.product', ['product' => $product->toArray()]);
    }
}
