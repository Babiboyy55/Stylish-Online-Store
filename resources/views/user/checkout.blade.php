@extends('layouts.user')
@section('title', 'Thanh toán')

@section('content')
<div class="container-lg py-5">
  <h1 class="mb-4">Thanh toán</h1>

  @if(session('status'))
  <div class="mb-4 p-3 bg-green-50 border border-green-100 text-green-700 rounded">{{ session('status') }}</div>
  @endif

  <div class="row">
    <div class="col-md-7">
      <div class="card p-4 mb-4">
        <h3 class="h5 mb-3">Thông tin người nhận</h3>
        <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname') }}" required>
            @error('fullname')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="0123456789" required>
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required>
            @error('address')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Phương thức thanh toán</label>
            <select id="payment-method" class="form-control" name="payment_method">
              <option value="cod">Thanh toán khi nhận hàng</option>
              <option value="card">Thẻ ngân hàng</option>
            </select>
          </div>

          <div id="bank-pay-block" class="mb-3" style="display:none;">
            <label class="form-label">Quét mã QR để thanh toán bằng thẻ ngân hàng</label>
            <div class="card p-3" style="max-width:260px;border-radius:8px;">
              <img src="{{ asset('user/images/qradmin.jpg') }}" alt="QR Bank" style="width:100%;height:auto;border-radius:6px;display:block;margin-bottom:10px;">
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-black">Đặt hàng</button>
            <a href="{{ url('/') }}" class="btn btn-outline-gray">Quay về trang chủ</a>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-5">
      <div class="card p-4">
        <h3 class="h5 mb-3">Tóm tắt đơn hàng</h3>
        @php $subtotal = 0; $cart = session('cart') ?? []; @endphp
        @if(count($cart) === 0)
        <p>Giỏ hàng trống.</p>
        @else
        <ul class="list-unstyled mb-3">
          @foreach($cart as $item)
          @php
          $line = $item['price'] * $item['qty'];
          $subtotal += $line;
          // Resolve image inline (supports session-stored image, uploaded 'products/' storage paths, and demo ids)
          $img = null;
          if (is_array($item) && array_key_exists('image', $item) && $item['image']) {
          if (str_starts_with($item['image'], 'products/')) {
          $img = \Illuminate\Support\Facades\Storage::url($item['image']);
          } else {
          $img = asset($item['image']);
          }
          } else {
          try {
          $lookupId = $item['id'] ?? null;
          $product = null;
          if ($lookupId) {
          if (!is_numeric($lookupId)) {
          $product = \App\Models\Product::where('sku', $lookupId)->orWhere('slug', $lookupId)->first();
          } else {
          $product = \App\Models\Product::find($lookupId);
          }
          }

          if ($product && !empty($product->image)) {
          if (str_starts_with($product->image, 'products/')) {
          $img = \Illuminate\Support\Facades\Storage::url($product->image);
          } else {
          $img = asset($product->image);
          }
          } else {
          if (is_string($lookupId) && preg_match('/^(men|women)-(\d+)$/', $lookupId, $m)) {
          $num = (int) $m[2];
          $imageIndex = ($num % 10) + 1;
          $img = asset("user/images/card-item{$imageIndex}.jpg");
          }
          }
          } catch (\Throwable $e) {
          $img = null;
          }
          }
          $img = $img ?? asset('user/images/card-item1.jpg');
          @endphp
          <li class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
              <img src="{{ $img }}" alt="{{ $item['name'] }}" style="width:60px;height:60px;object-fit:cover;border-radius:6px;margin-right:12px;">
              <div>
                <div class="fw-bold">{{ $item['name'] }}</div>
                <div class="text-muted">Qty: {{ $item['qty'] }}</div>
              </div>
            </div>
            <div>${{ number_format($line,2) }}</div>
          </li>
          @endforeach
        </ul>
        <div class="d-flex justify-content-between fw-bold mb-2">
          <div>Tạm tính</div>
          <div>${{ number_format($subtotal,2) }}</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Vận chuyển</div>
          <div class="text-muted">Miễn phí</div>
        </div>
        <div class="d-flex justify-content-between fw-bold mb-3">
          <div>Tổng</div>
          <div>${{ number_format($subtotal,2) }}</div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Form submits to server; server will create order and redirect -->
</div>
@endsection

@push('scripts')
<script>
  (function() {
    var sel = document.getElementById('payment-method');
    var block = document.getElementById('bank-pay-block');
    if (!sel || !block) return;

    function update() {
      if (sel.value === 'card') block.style.display = '';
      else block.style.display = 'none';
    }
    sel.addEventListener('change', update);
    // init
    update();

    // Add confirmation before submitting order
    var form = document.getElementById('checkout-form');
    var submitBtn = form.querySelector('button[type="submit"]');
    var originalBtnText = submitBtn.textContent;
    
    form.addEventListener('submit', function(e) {
      // Prevent default submission
      e.preventDefault();
      
      // Show confirmation dialog
      if (confirm('Bạn có chắc chắn muốn đặt hàng?\n\nVui lòng kiểm tra lại thông tin trước khi xác nhận.')) {
        // User confirmed, disable button and show loading
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang xử lý...';
        
        // Submit the form
        form.submit();
      }
    });
  })();
</script>
@endpush