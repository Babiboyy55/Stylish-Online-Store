@extends('layouts.admin')

@section('title', 'Thêm Sản phẩm')

@section('content')
    <div class="my-6">
        <a href="{{ route('admin.products.index') }}" class="text-purple-600 hover:underline">
            ← Quay lại danh sách
        </a>
    </div>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">Tên sản phẩm <span class="text-red-600">*</span></span>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="VD: Giày Nike Air Max 2024" />
                @error('name')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Danh mục <span class="text-red-600">*</span></span>
                                <select name="category_id" required
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Mô tả</span>
                                <textarea name="description" rows="3"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                    placeholder="Mô tả chi tiết về sản phẩm...">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <div class="grid gap-6 mt-4 mb-4 md:grid-cols-2">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Giá gốc (₫) <span class="text-red-600">*</span></span>
                                    <input type="number" name="price" value="{{ old('price') }}" required min="0" step="any"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="99" />
                                    @error('price')
                                        <span class="text-xs text-red-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Giá khuyến mãi (₫)</span>
                                    <input type="number" name="sale_price" value="{{ old('sale_price') }}" min="0" step="any"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="89" />
                                    @error('sale_price')
                                        <span class="text-xs text-red-600">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>

                            <div class="grid gap-6 mt-4 mb-4 md:grid-cols-3">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Số lượng tồn kho <span class="text-red-600">*</span></span>
                                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                    @error('stock')
                                        <span class="text-xs text-red-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Size</span>
                                    <input type="text" name="size" value="{{ old('size') }}"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="36,37,38,39,40" />
                                    @error('size')
                                        <span class="text-xs text-red-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Màu sắc</span>
                                    <input type="text" name="color" value="{{ old('color') }}"
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="Đen, Trắng, Xanh" />
                                    @error('color')
                                        <span class="text-xs text-red-600">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>

                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Hình ảnh</span>
                                <input type="file" name="image" accept="image/*"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray" />
                                @error('image')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <div class="flex mt-6 text-sm">
                                <label class="flex items-center dark:text-gray-400">
                                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                        class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
                                    <span class="ml-2">Sản phẩm nổi bật</span>
                                </label>
                            </div>

                            <div class="flex mt-4 text-sm">
                                <label class="flex items-center dark:text-gray-400">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                        class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
                                    <span class="ml-2">Hiển thị sản phẩm</span>
                                </label>
                            </div>

                            <div class="flex justify-end mt-6 space-x-2">
                                <a href="{{ route('admin.products.index') }}"
                                    class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                                    Hủy
                                </a>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    Thêm sản phẩm
                                </button>
                            </div>
                        </form>
                    </div>
@endsection
