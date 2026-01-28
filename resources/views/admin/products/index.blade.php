@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="flex justify-between items-center my-6">
    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Danh sách Sản phẩm</h2>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Thêm sản phẩm mới
    </a>
</div>

@if(session('success'))
<div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-200 text-green-700">{{ session('success') }}</div>
@endif

<div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Sản phẩm</th>
                    <th class="px-4 py-3">Danh mục</th>
                    <th class="px-4 py-3">Giá</th>
                    <th class="px-4 py-3">Tồn kho</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @forelse($products as $product)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            @if($product->image)
                            <div class="relative hidden w-12 h-12 mr-3 rounded-full md:block">
                                <img class="object-cover w-full h-full rounded" src="{{ \App\Helpers\ImageHelper::productImageUrl($product->image) }}" alt="{{ $product->name }}" loading="lazy" />
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold">{{ $product->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ Str::limit($product->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $product->category->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($product->sale_price)
                        <span class="line-through text-gray-400">{{ number_format($product->price, 0, ',', '.') }}₫</span><br>
                        <span class="text-red-600 font-semibold">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                        @else
                        <span class="font-semibold">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $product->stock }}</td>
                    <td class="px-4 py-3 text-xs">
                        @if($product->is_active)
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Đang bán</span>
                        @else
                        <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">Tạm ẩn</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                            <a href="{{ route('admin.products.edit', $product) }}" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-sm text-center text-gray-700 dark:text-gray-400">Chưa có sản phẩm nào. <a href="{{ route('admin.products.create') }}" class="text-purple-600 hover:underline">Thêm sản phẩm đầu tiên</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        {{ $products->links() }}
    </div>
</div>
@endsection