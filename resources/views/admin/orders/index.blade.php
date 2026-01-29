@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Quản lý Đơn hàng
        </h2>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 border border-green-400 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Mã đơn</th>
                            <th class="px-4 py-3">Khách hàng</th>
                            <th class="px-4 py-3">Tổng tiền</th>
                            <th class="px-4 py-3">Trạng thái</th>
                            <th class="px-4 py-3">Ngày đặt</th>
                            <th class="px-4 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($orders as $order)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm font-semibold">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $order->user->name ?? 'Guest' }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $order->user->email ?? $order->email }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold">
                                    {{ number_format($order->total, 0, ',', '.') }} ₫
                                </td>
                                <td class="px-4 py-3 text-xs">
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
                                    <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-200 text-gray-900 dark:bg-gray-600 dark:text-white' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="View">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                    Không có đơn hàng nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
