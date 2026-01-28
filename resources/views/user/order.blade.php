@extends('layouts.user')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-12">
      <div class="card p-4">
        <h3>Đơn hàng #{{ $order->id }}</h3>
        <p class="text-muted">Ngày: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Người nhận:</strong> {{ $order->fullname }} &nbsp; <strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <hr>
        <h5>Sản phẩm</h5>
        <ul class="list-group mb-3">
          @foreach($order->items as $it)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-bold">{{ $it->name }}</div>
                <small class="text-muted">Số lượng: {{ $it->qty }}</small>
              </div>
              <div class="fw-bold">${{ number_format($it->total,2) }}</div>
            </li>
          @endforeach
        </ul>
        <div class="d-flex justify-content-end align-items-center gap-3">
          <div class="text-end">
            <div>Subtotal: ${{ number_format($order->subtotal,2) }}</div>
            <div>Shipping: ${{ number_format($order->shipping,2) }}</div>
            <div class="fw-bold">Total: ${{ number_format($order->total,2) }}</div>
          </div>
        </div>
        <div class="mt-3">
          @if($order->status !== 'paid')
            <form method="POST" action="{{ url('/account/orders/'.$order->id.'/pay') }}">
              @csrf
              <button class="btn btn-primary">Thanh toán</button>
            </form>
          @else
            <span class="badge bg-success">Đã thanh toán</span>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
