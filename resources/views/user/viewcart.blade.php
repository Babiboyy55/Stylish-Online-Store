@extends('layouts.user')
@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="container-lg py-5">
  <h1 class="mb-4">Giỏ hàng của bạn</h1>

  @if(session('cart') && count(session('cart')))
    <div class="cart-wrapper d-flex gap-4">
      <div class="cart-items flex-grow-1">
        @foreach(session('cart') as $item)
          <div class="cart-item d-flex align-items-center justify-content-between border-bottom py-3">
            <div class="d-flex align-items-center">
        @php
        $img = \App\Helpers\ImageHelper::productImageUrl($item['image'] ?? null, null, $item['id'] ?? null);
        @endphp
        <img src="{{ $img }}" alt="{{ $item['name'] }}" style="width:80px;height:80px;object-fit:cover;border-radius:6px;margin-right:16px;">
              <div>
                <div class="fw-bold">{{ $item['name'] }}</div>
                <div class="text-muted">SKU: {{ $item['id'] }}</div>
              </div>
            </div>

            <div class="d-flex align-items-center">
              <form method="POST" action="{{ route('cart.update') }}" style="display:inline-flex;align-items:center;">
                @csrf
                <input type="hidden" name="id" value="{{ $item['id'] }}">
                <button type="button" onclick="this.parentElement.querySelector('input[name=qty]').stepDown();" class="btn btn-light" style="padding:6px 10px;">-</button>
                <input type="number" name="qty" value="{{ $item['qty'] }}" min="0" style="width:60px;text-align:center;margin:0 8px;padding:6px;border:1px solid #eee;border-radius:6px;">
                <button type="button" onclick="this.parentElement.querySelector('input[name=qty]').stepUp();" class="btn btn-light" style="padding:6px 10px;">+</button>
                <button class="btn btn-sm btn-black ms-2" type="submit">Cập nhật</button>
              </form>
              <div style="width:120px;text-align:right;margin-left:24px;">
                <div class="fw-bold">${{ number_format($item['price'] * $item['qty'],2) }}</div>
                <form method="POST" action="{{ route('cart.remove') }}">
                  @csrf
                  <input type="hidden" name="id" value="{{ $item['id'] }}">
                  <button class="btn btn-sm btn-outline-gray mt-2" type="submit">Xóa</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <aside class="cart-summary mt-4 p-3 border rounded" style="max-width:360px;">
        <h3 class="h5 mb-3">Tóm tắt đơn hàng</h3>
        @php $subtotal = 0; @endphp
        @foreach(session('cart') as $item)
          @php $subtotal += $item['price'] * $item['qty']; @endphp
        @endforeach
        <div class="d-flex justify-content-between mb-2">
          <div>Tạm tính</div>
          <div class="fw-bold">${{ number_format($subtotal,2) }}</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Vận chuyển</div>
          <div class="text-muted">Miễn phí</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Tổng</div>
          <div class="fw-bold">${{ number_format($subtotal,2) }}</div>
        </div>

        <div class="d-flex gap-2">
          <a href="{{ url('/checkout') }}" class="btn btn-black w-100">Tiến hành thanh toán</a>
        </div>

        <div class="d-flex gap-2 mt-3">
          <form method="POST" action="{{ route('cart.clear') }}" style="flex:1;">
            @csrf
            <button type="submit" class="btn btn-outline-gray w-100">Xóa giỏ hàng</button>
          </form>
          <a href="{{ route('cart.add.sample') }}" class="btn btn-outline-gray" style="width:120px;">Thêm mẫu</a>
        </div>
      </aside>
    </div>
  @else
    <p>Giỏ hàng trống.</p>
    <a href="{{ url('/') }}" class="btn btn-outline-gray">Tiếp tục mua sắm</a>
  @endif
</div>

@endsection
