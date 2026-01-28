@extends('layouts.admin')

@section('title', 'Thêm Danh mục')

@section('content')
    <div class="my-6">
        <a href="{{ route('admin.categories.index') }}" class="text-purple-600 hover:underline">
            ← Quay lại danh sách
        </a>
    </div>

                    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Tên danh mục <span class="text-red-600">*</span></span>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="VD: Giày Nam, Giày Nữ, Giày Thể Thao..." />
                                @error('name')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Mô tả</span>
                                <textarea name="description" rows="3"
                                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                    placeholder="Mô tả về danh mục này...">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm mt-4">
                                <span class="text-gray-700 dark:text-gray-400">Hình ảnh danh mục</span>
                                <input type="file" name="image" accept="image/*"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray" />
                                <span class="text-xs text-gray-600 dark:text-gray-400">Hình ảnh đại diện cho danh mục</span>
                                @error('image')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <div class="flex justify-end mt-6 space-x-2">
                                <a href="{{ route('admin.categories.index') }}"
                                    class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                                    Hủy
                                </a>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    Thêm danh mục
                                </button>
                            </div>
                        </form>
                    </div>
@endsection
