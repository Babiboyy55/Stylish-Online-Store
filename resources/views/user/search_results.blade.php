@extends('layouts.user')
@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="container-lg py-5">
  <div class="mb-4">
    <h1 class="h2">Kết quả tìm kiếm</h1>
    @if($q)
      <p class="text-muted">Từ khóa: <strong>"{{ e($q) }}"</strong> - Tìm thấy <strong>{{ count($products) }}</strong> sản phẩm</p>
    @endif
  </div>

  @if(empty($q))
    <div class="alert alert-info">
      <i class="bi bi-info-circle me-2"></i>
      Vui lòng nhập từ khóa tìm kiếm.
    </div>
    <a href="{{ url('/') }}" class="btn btn-primary">Về trang chủ</a>
  @else
    @if(count($products) === 0)
      <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Không tìm thấy sản phẩm nào cho từ khóa <strong>"{{ e($q) }}"</strong>
      </div>
      <div class="mt-3">
        <p>Gợi ý:</p>
        <ul>
          <li>Kiểm tra lại chính tả từ khóa</li>
          <li>Thử sử dụng từ khóa khác</li>
          <li>Sử dụng từ khóa ngắn gọn hơn</li>
        </ul>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Xem tất cả sản phẩm</a>
      </div>
    @else
      <!-- Products Grid -->
      <div class="row g-4">
        @foreach($products as $product)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card product-card h-100 border-0 shadow-sm">
              <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none">
                @php
                  $image = null;
                  if (!empty($product->image)) {
                    if (str_starts_with($product->image, 'products/')) {
                      $image = \Illuminate\Support\Facades\Storage::url($product->image);
                    } else {
                      $image = asset($product->image);
                    }
                  } else {
                    $image = asset('user/images/card-item1.jpg');
                  }
                @endphp
                <img src="{{ $image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                
                @if($product->sale_price && $product->sale_price > 0)
                  <div class="position-absolute top-0 start-0 m-2">
                    <span class="badge bg-danger">
                      SALE -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                    </span>
                  </div>
                @endif
              </a>
              
              <div class="card-body">
                <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
                  <h6 class="card-title mb-2" style="min-height: 40px;">{{ $product->name }}</h6>
                </a>
                
                <div class="mb-2">
                  @if($product->sale_price && $product->sale_price > 0)
                    <span class="text-muted text-decoration-line-through me-2">${{ number_format($product->price, 2) }}</span>
                    <span class="text-danger fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                  @else
                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                  @endif
                </div>

                @if($product->sku)
                  <p class="text-muted small mb-2">SKU: {{ $product->sku }}</p>
                @endif
                
                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                  @csrf
                  <input type="hidden" name="id" value="{{ $product->id }}">
                  <input type="hidden" name="qty" value="1">
                  <button type="submit" class="btn btn-dark btn-sm w-100">
                    <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  @endif
</div>

<style>
.product-card {
  transition: transform 0.2s, box-shadow 0.2s;
}
.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection
