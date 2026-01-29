@extends('layouts.admin')

@section('title', 'Chi tiết Đơn hàng')

@section('content')
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center my-6">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Chi tiết Đơn hàng #{{ $order->id }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-lg dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600 hover:bg-gray-100 focus:outline-none">
                ← Quay lại
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 border border-green-400 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded bg-red-100 border border-red-400 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <!-- Order Info -->
            <div class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Thông tin đơn hàng
                </h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Mã đơn:</span>
                        <span class="font-semibold text-gray-700 dark:text-gray-200">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Ngày đặt:</span>
                        <span class="text-gray-700 dark:text-gray-200">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Trạng thái:</span>
                        <span>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-200 text-yellow-900 dark:bg-yellow-600 dark:text-white',
                                    'processing' => 'bg-blue-200 text-blue-900 dark:bg-blue-600 dark:text-white',
                                    'shipped' => 'bg-purple-200 text-purple-900 dark:bg-purple-600 dark:text-white',
                                    'delivered' => 'bg-green-200 text-green-900 dark:bg-green-600 dark:text-white',
                                    'cancelled' => 'bg-red-200 text-red-900 dark:bg-red-600 dark:text-white',
                                ];
                                $statusLabels = [
                                    'pending' => 'Chờ xử lý',
                                    'processing' => 'Đang xử lý',
                                    'shipped' => 'Đã gửi hàng',
                                    'delivered' => 'Đã giao',
                                    'cancelled' => 'Đã hủy',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-200 text-gray-900 dark:bg-gray-600 dark:text-white' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Tổng tiền:</span>
                        <span class="font-bold text-lg text-purple-600 dark:text-purple-400">{{ number_format($order->total, 0, ',', '.') }} ₫</span>
                    </div>
                </div>

                <!-- Update Status -->
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mt-6">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                        Cập nhật trạng thái
                    </label>
                    <div class="flex space-x-2">
                        <select name="status" class="block w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                        <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Cập nhật
                        </button>
                    </div>
                </form>

                <!-- Quick Actions: Approve/Reject -->
                @if($order->status == 'pending')
                    <div class="mt-4 pt-4 border-t dark:border-gray-600">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-3">
                            Thao tác nhanh
                        </label>
                        <div class="flex gap-3">
                            <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" onclick="return confirm('Bạn có chắc muốn phê duyệt đơn hàng này?')" 
                                    class="w-full px-4 py-3 text-sm font-bold leading-5 text-gray-800 bg-white transition-all duration-150 border-2 border-green-600 rounded-lg hover:bg-green-50 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Phê duyệt
                                    </span>
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.reject', $order) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" onclick="return confirm('Bạn có chắc muốn từ chối đơn hàng này?')" 
                                    class="w-full px-4 py-3 text-sm font-bold leading-5 text-gray-800 bg-white transition-all duration-150 border-2 border-red-600 rounded-lg hover:bg-red-50 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Từ chối
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif(in_array($order->status, ['processing']))
                    <div class="mt-4 pt-4 border-t dark:border-gray-600">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-3">
                            Thao tác
                        </label>
                        <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')" 
                                class="w-full px-4 py-3 text-sm font-bold leading-5 text-gray-800 bg-white transition-all duration-150 border-2 border-red-600 rounded-lg hover:bg-red-50 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Hủy đơn hàng
                                </span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Customer Info -->
            <div class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Thông tin khách hàng
                </h4>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Tên:</span>
                        <p class="font-semibold text-gray-700 dark:text-gray-200">{{ $order->user->name ?? 'Guest' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Email:</span>
                        <p class="text-gray-700 dark:text-gray-200">{{ $order->user->email ?? $order->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Số điện thoại:</span>
                        <p class="text-gray-700 dark:text-gray-200">{{ $order->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Địa chỉ giao hàng:</span>
                        <p class="text-gray-700 dark:text-gray-200">{{ $order->shipping_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mb-8">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Sản phẩm</th>
                            <th class="px-4 py-3">Đơn giá</th>
                            <th class="px-4 py-3">Số lượng</th>
                            <th class="px-4 py-3">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($order->orderItems as $item)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div class="relative hidden w-12 h-12 mr-3 rounded md:block">
                                            @if($item->image)
                                                <img class="object-cover w-full h-full rounded" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                                            @elseif($item->product && $item->product->image)
                                                <img class="object-cover w-full h-full rounded" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->name }}" loading="lazy">
                                            @else
                                                <div class="w-full h-full bg-gray-300 rounded flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $item->name }}</p>
                                            @if($item->product)
                                                <p class="text-xs text-gray-600 dark:text-gray-400">SKU: {{ $item->product->sku }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ number_format($item->price, 0, ',', '.') }} ₫
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $item->qty }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold">
                                    {{ number_format($item->total, 0, ',', '.') }} ₫
                                </td>
                            </tr>
                        @endforeach
                        <tr class="text-gray-700 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
                            <td colspan="3" class="px-4 py-3 text-sm font-semibold text-right">
                                Tổng cộng:
                            </td>
                            <td class="px-4 py-3 text-sm font-bold text-purple-600 dark:text-purple-400">
                                {{ number_format($order->total, 0, ',', '.') }} ₫
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
