@extends('layouts.user')
@section('title', 'Chi tiết sản phẩm')

@section('content')
@php
  // Accept either an array (from controller->toArray()) or a model instance
  $prod = is_array($product) ? $product : (is_object($product) ? (method_exists($product, 'toArray') ? $product->toArray() : (array)$product) : (array)$product);
  $prodPrice = (float)($prod['price'] ?? ($product->price ?? 0));
@endphp
<div class="container mt-4">
  <div class="row bg-white rounded shadow p-4 g-4 align-items-start">
    <div class="col-12 col-md-6">
      @php $prodImg = \App\Helpers\ImageHelper::productImageUrl($prod['image'] ?? null, $prod, $prod['id'] ?? ($prod['sku'] ?? null)); @endphp
      <img src="{{ $prodImg }}" alt="{{ $prod['name'] ?? '' }}" class="img-fluid rounded w-100">
    </div>

    <div class="col-12 col-md-6">
      <div class="d-flex flex-column h-100">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
          <h1 class="h4 mb-2 mb-md-0">{{ $prod['name'] ?? '' }}</h1>
          <p class="h5 text-danger fw-bold mb-0">${{ number_format($prodPrice, 2) }}</p>
        </div>

        <p class="mb-4">{{ $prod['description'] ?? '' }}</p>

        <form method="POST" action="{{ url('/cart/add') }}" class="mt-auto">
          @csrf
          <input type="hidden" name="id" value="{{ $prod['id'] ?? ($prod['sku'] ?? '') }}">
          <input type="hidden" name="name" value="{{ $prod['name'] ?? '' }}">
          <input type="hidden" name="price" value="{{ $prodPrice }}">

          <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
            <div class="d-flex align-items-center gap-2">
              <label for="qty" class="mb-0">Số lượng</label>
              <input id="qty" name="qty" type="number" value="1" min="1" class="form-control" style="width:80px;">
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-warning fw-bold">Thêm vào giỏ</button>
              <a href="{{ url('/') }}" class="btn btn-secondary">Tiếp tục mua hàng</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection