@extends('layouts.admin')

@section('title', 'Chỉnh sửa Người dùng')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Chỉnh sửa Người dùng
        </h2>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="name">
                        Tên người dùng <span class="text-red-600">*</span>
                    </label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('name') border-red-600 @enderror" 
                           type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           required>
                    @error('name')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="email">
                        Email <span class="text-red-600">*</span>
                    </label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('email') border-red-600 @enderror" 
                           type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           required>
                    @error('email')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="username">
                        Username
                    </label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('username') border-red-600 @enderror" 
                           type="text" 
                           id="username" 
                           name="username" 
                           value="{{ old('username', $user->username) }}">
                    @error('username')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="password">
                        Mật khẩu mới
                    </label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('password') border-red-600 @enderror" 
                           type="password" 
                           id="password" 
                           name="password">
                    @error('password')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">Để trống nếu không muốn đổi mật khẩu</p>
                </div>

                <!-- Password Confirmation -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="password_confirmation">
                        Xác nhận mật khẩu mới
                    </label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                           type="password" 
                           id="password_confirmation" 
                           name="password_confirmation">
                </div>

                <!-- Is Admin -->
                <div class="mb-6">
                    <label class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                        <input type="checkbox" 
                               class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" 
                               name="is_admin" 
                               value="1"
                               {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <span class="ml-2">Đặt làm Admin</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Cập nhật
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-lg dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600 active:bg-gray-100 hover:bg-gray-100 focus:outline-none focus:shadow-outline-gray">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
