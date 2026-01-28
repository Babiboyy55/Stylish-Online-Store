@extends('layouts.user')
@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container-lg py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <!-- Success Message -->
      <div class="text-center mb-5">
        <div class="mb-4">
          <svg class="text-success" width="80" height="80" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
          </svg>
        </div>
        <h1 class="h2 mb-3">🎉 Đặt hàng thành công!</h1>
        <p class="text-muted">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất.</p>
      </div>

      <!-- Order Details Card -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Thông tin đơn hàng</h5>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-sm-4 text-muted">Mã đơn hàng:</div>
            <div class="col-sm-8"><strong>#{{ $order->id }}</strong></div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-4 text-muted">Ngày đặt:</div>
            <div class="col-sm-8">{{ $order->created_at->format('d/m/Y H:i') }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-4 text-muted">Trạng thái:</div>
            <div class="col-sm-8">
              @if($order->status === 'processing')
                <span class="badge bg-warning text-dark">Đang xử lý</span>
              @elseif($order->status === 'paid')
                <span class="badge bg-success">Đã thanh toán</span>
              @elseif($order->status === 'completed')
                <span class="badge bg-success">Hoàn thành</span>
              @else
                <span class="badge bg-secondary">{{ $order->status }}</span>
              @endif
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-4 text-muted">Phương thức thanh toán:</div>
            <div class="col-sm-8">
              @if($order->payment_method === 'cod')
                Thanh toán khi nhận hàng
              @elseif($order->payment_method === 'card')
                Thẻ ngân hàng
              @else
                {{ $order->payment_method ?? 'Chưa xác định' }}
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Customer Info Card -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Thông tin người nhận</h5>
        </div>
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Họ và tên:</div>
            <div class="col-sm-8">{{ $order->fullname }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Email:</div>
            <div class="col-sm-8">{{ $order->email }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Số điện thoại:</div>
            <div class="col-sm-8">{{ $order->phone ?? 'Chưa cung cấp' }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-4 text-muted">Địa chỉ:</div>
            <div class="col-sm-8">{{ $order->address }}</div>
          </div>
        </div>
      </div>

      <!-- Order Items Card -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0">Sản phẩm đã đặt</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-borderless mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="px-4 py-3">Sản phẩm</th>
                  <th class="px-4 py-3 text-center">Số lượng</th>
                  <th class="px-4 py-3 text-end">Đơn giá</th>
                  <th class="px-4 py-3 text-end">Thành tiền</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                <tr>
                  <td class="px-4 py-3">
                    <div class="d-flex align-items-center">
                      @if($item->image)
                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                      @endif
                      <div>
                        <div class="fw-semibold">{{ $item->name }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-center">{{ $item->qty }}</td>
                  <td class="px-4 py-3 text-end">${{ number_format($item->price, 2) }}</td>
                  <td class="px-4 py-3 text-end fw-semibold">${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Order Summary Card -->
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Tạm tính:</span>
            <span>${{ number_format($order->subtotal, 2) }}</span>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <span class="text-muted">Phí vận chuyển:</span>
            <span>
              @if($order->shipping > 0)
                ${{ number_format($order->shipping, 2) }}
              @else
                <span class="text-success">Miễn phí</span>
              @endif
            </span>
          </div>
          <hr>
          <div class="d-flex justify-content-between">
            <span class="h5 mb-0">Tổng cộng:</span>
            <span class="h5 mb-0 text-primary">${{ number_format($order->total, 2) }}</span>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="text-center">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary me-2">
          <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
          </svg>
          Về trang chủ
        </a>
        @auth
        <a href="{{ route('account') }}" class="btn btn-primary">
          Xem đơn hàng của tôi
        </a>
        @endauth
      </div>
    </div>
  </div>
</div>
@endsection
