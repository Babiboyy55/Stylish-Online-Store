# 📚 HƯỚNG DẪN HỌC PHẦN ADMIN - LARAVEL

## 📋 MỤC LỤC
1. [Tổng quan kiến trúc](#1-tổng-quan-kiến-trúc)
2. [Middleware bảo mật](#2-middleware-bảo-mật)
3. [Routes (Định tuyến)](#3-routes-định-tuyến)
4. [Controllers](#4-controllers)
5. [Models & Database](#5-models--database)
6. [Views (Giao diện)](#6-views-giao-diện)
7. [Luồng xử lý](#7-luồng-xử-lý)

---

## 1. TỔNG QUAN KIẾN TRÚC

### 📁 Cấu trúc thư mục Admin

```
app/
├── Http/
│   ├── Controllers/Admin/
│   │   ├── AdminDashboardController.php
│   │   ├── CategoryController.php
│   │   ├── OrderController.php
│   │   ├── ProductController.php
│   │   └── UserController.php
│   └── Middleware/
│       └── IsAdmin.php
│
resources/views/admin/
├── categories/          # Quản lý danh mục
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── orders/             # Quản lý đơn hàng
│   ├── index.blade.php
│   └── show.blade.php
├── products/           # Quản lý sản phẩm
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── users/              # Quản lý người dùng
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── partials/           # Components dùng chung
├── dashboard.blade.php # Trang chủ admin
├── charts.blade.php    # Trang biểu đồ
└── tables.blade.php    # Trang bảng mẫu

routes/
└── web.php             # Định nghĩa routes admin
```

---

## 2. MIDDLEWARE BẢO MẬT

### 📄 File: `app/Http/Middleware/IsAdmin.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Kiểm tra user có phải admin không
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Nếu chưa đăng nhập hoặc không phải admin → Chặn (403)
        if (!$user || !$user->is_admin) {
            abort(403, 'Unauthorized.');
        }

        // Cho phép tiếp tục
        return $next($request);
    }
}
```

### 🔑 Cách hoạt động:
1. **Auth::user()**: Lấy thông tin user đang đăng nhập
2. **$user->is_admin**: Kiểm tra cột `is_admin` trong bảng `users`
3. **abort(403)**: Trả về lỗi 403 nếu không phải admin
4. **$next($request)**: Cho phép request tiếp tục nếu hợp lệ

### 📝 Đăng ký Middleware

File: `bootstrap/app.php` hoặc `app/Http/Kernel.php`

```php
protected $middlewareAliases = [
    'is_admin' => \App\Http\Middleware\IsAdmin::class,
];
```

---

## 3. ROUTES (ĐỊNH TUYẾN)

### 📄 File: `routes/web.php`

```php
// Redirect /admin → /admin/dashboard
Route::redirect('/admin', '/admin/dashboard')->name('admin');

// Nhóm routes admin với middleware bảo vệ
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'is_admin'])  // Phải đăng nhập + là admin
    ->group(function () {
    
    // Dashboard
    Route::view('/', 'admin.index')->name('dashboard');
    Route::view('/dashboard', 'admin.index');
    
    // ===== PRODUCTS (CRUD đầy đủ) =====
    Route::get('products', [AdminProductController::class, 'index'])
        ->name('products.index');           // Danh sách
    Route::get('products/create', [AdminProductController::class, 'create'])
        ->name('products.create');          // Form thêm
    Route::post('products', [AdminProductController::class, 'store'])
        ->name('products.store');           // Lưu mới
    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])
        ->name('products.edit');            // Form sửa
    Route::put('products/{product}', [AdminProductController::class, 'update'])
        ->name('products.update');          // Cập nhật
    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])
        ->name('products.destroy');         // Xóa
    
    // ===== CATEGORIES (CRUD đầy đủ) =====
    Route::get('categories', [AdminCategoryController::class, 'index'])
        ->name('categories.index');
    Route::get('categories/create', [AdminCategoryController::class, 'create'])
        ->name('categories.create');
    Route::post('categories', [AdminCategoryController::class, 'store'])
        ->name('categories.store');
    Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])
        ->name('categories.edit');
    Route::put('categories/{category}', [AdminCategoryController::class, 'update'])
        ->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])
        ->name('categories.destroy');
    
    // ===== USERS (CRUD đầy đủ) =====
    Route::get('users', [AdminUserController::class, 'index'])
        ->name('users.index');
    Route::get('users/create', [AdminUserController::class, 'create'])
        ->name('users.create');
    Route::post('users', [AdminUserController::class, 'store'])
        ->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])
        ->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])
        ->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])
        ->name('users.destroy');
    
    // ===== ORDERS (Chỉ xem + cập nhật trạng thái) =====
    Route::get('orders', [AdminOrderController::class, 'index'])
        ->name('orders.index');             // Danh sách
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])
        ->name('orders.show');              // Chi tiết
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');      // Đổi trạng thái
    Route::post('orders/{order}/approve', [AdminOrderController::class, 'approve'])
        ->name('orders.approve');           // Phê duyệt
    Route::post('orders/{order}/reject', [AdminOrderController::class, 'reject'])
        ->name('orders.reject');            // Từ chối
    
    // ===== STATIC PAGES =====
    Route::view('charts', 'admin.charts');
    Route::view('tables', 'admin.tables');
});
```

### 🎯 Các khái niệm quan trọng:

#### **Route Prefix & Name**
```php
Route::prefix('admin')      // URL: /admin/...
    ->name('admin.')        // Tên route: admin.xxx
```

#### **Route Parameters**
```php
Route::get('products/{product}/edit', ...)
// {product} → Laravel tự động tìm Product theo ID
// URL: /admin/products/5/edit → $product = Product::find(5)
```

#### **HTTP Methods**
- `GET`: Lấy dữ liệu (hiển thị trang)
- `POST`: Tạo mới
- `PUT/PATCH`: Cập nhật
- `DELETE`: Xóa

---

## 4. CONTROLLERS

### 📂 Các Controller Admin

```
app/Http/Controllers/Admin/
├── AdminDashboardController.php   # Trang chủ admin
├── CategoryController.php         # CRUD danh mục
├── OrderController.php            # Quản lý đơn hàng
├── ProductController.php          # CRUD sản phẩm
└── UserController.php             # CRUD người dùng
```

### 🔍 Phân tích chi tiết một Controller

#### **1. ProductController.php** (Ví dụ đầy đủ)

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * 1. INDEX - Hiển thị danh sách sản phẩm
     * URL: GET /admin/products
     */
    public function index()
    {
        // Lấy tất cả sản phẩm + kèm category (tối ưu N+1 query)
        $products = Product::with('category')
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);  // Phân trang 20 items/trang
        
        return view('admin.products.index', compact('products'));
    }
    
    /**
     * 2. CREATE - Hiển thị form thêm mới
     * URL: GET /admin/products/create
     */
    public function create()
    {
        $categories = Category::all();  // Lấy danh sách category cho dropdown
        return view('admin.products.create', compact('categories'));
    }
    
    /**
     * 3. STORE - Lưu sản phẩm mới vào DB
     * URL: POST /admin/products
     */
    public function store(Request $request)
    {
        // Validation - Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Xử lý upload hình ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                        ->store('products', 'public');  // Lưu vào storage/app/public/products
            $validated['image'] = $imagePath;
        }
        
        // Tự động tạo slug từ tên
        $validated['slug'] = Str::slug($validated['name']);
        
        // Tạo sản phẩm mới
        Product::create($validated);
        
        // Redirect với thông báo thành công
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Tạo sản phẩm thành công!');
    }
    
    /**
     * 4. EDIT - Hiển thị form sửa
     * URL: GET /admin/products/{product}/edit
     */
    public function edit(Product $product)  // Route Model Binding
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    
    /**
     * 5. UPDATE - Cập nhật sản phẩm
     * URL: PUT /admin/products/{product}
     */
    public function update(Request $request, Product $product)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Upload hình mới (nếu có)
        if ($request->hasFile('image')) {
            // Xóa hình cũ
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')
                                ->store('products', 'public');
        }
        
        // Update slug nếu đổi tên
        if ($validated['name'] !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Cập nhật
        $product->update($validated);
        
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }
    
    /**
     * 6. DESTROY - Xóa sản phẩm
     * URL: DELETE /admin/products/{product}
     */
    public function destroy(Product $product)
    {
        // Xóa hình ảnh trên storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Xóa sản phẩm
        $product->delete();
        
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }
}
```

### 📌 Các khái niệm quan trọng:

#### **Route Model Binding**
```php
public function edit(Product $product)
```
- Laravel tự động tìm `Product` theo ID trong URL
- Nếu không tìm thấy → Tự động trả về 404

#### **Validation**
```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
]);
```
- Kiểm tra dữ liệu đầu vào
- Nếu lỗi → Tự động quay lại với thông báo lỗi

#### **File Upload**
```php
$path = $request->file('image')->store('products', 'public');
```
- Lưu file vào `storage/app/public/products/`
- Trả về đường dẫn: `products/abc123.jpg`

#### **Flash Session**
```php
->with('success', 'Thành công!')
```
- Lưu message vào session (chỉ tồn tại 1 request)
- View hiển thị: `@if(session('success')) ... @endif`

---

## 5. MODELS & DATABASE

### 📄 Model: `app/Models/Product.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Các cột được phép gán giá trị hàng loạt
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'image',
        'category_id',
        'stock',
        'is_featured',
        'is_active',
    ];
    
    // Tự động cast kiểu dữ liệu
    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    // ===== RELATIONSHIPS =====
    
    /**
     * Một Product thuộc về một Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Một Product có nhiều OrderItems
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    // ===== ACCESSORS & MUTATORS =====
    
    /**
     * Tính giá cuối cùng (ưu tiên sale_price)
     */
    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }
    
    /**
     * Lấy URL hình ảnh đầy đủ
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }
}
```

### 🗄️ Database Structure

#### **Bảng: products**
```sql
CREATE TABLE products (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2) NULL,
    image VARCHAR(255),
    category_id BIGINT,
    stock INT DEFAULT 0,
    is_featured BOOLEAN DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
```

#### **Bảng: orders**
```sql
CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    total DECIMAL(10,2),
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled'),
    shipping_address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### **Bảng: order_items**
```sql
CREATE TABLE order_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT,
    product_id BIGINT,
    name VARCHAR(255),
    image VARCHAR(255),        -- Lưu hình tại thời điểm đặt hàng
    price DECIMAL(10,2),
    qty INT,
    total DECIMAL(10,2),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 6. VIEWS (GIAO DIỆN)

### 📄 Layout chính: `resources/views/layouts/admin.blade.php`

```blade
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin Panel</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    @include('admin.partials.sidebar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
```

### 📄 Trang danh sách: `resources/views/admin/products/index.blade.php`

```blade
@extends('layouts.admin')

@section('title', 'Danh sách Sản phẩm')

@section('content')
<div class="container mx-auto px-6">
    <!-- Header -->
    <div class="flex justify-between items-center my-6">
        <h2 class="text-2xl font-semibold">Danh sách Sản phẩm</h2>
        <a href="{{ route('admin.products.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded">
            Thêm mới
        </a>
    </div>
    
    <!-- Thông báo thành công -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Bảng dữ liệu -->
    <div class="bg-white shadow-md rounded">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3">Hình</th>
                    <th class="px-6 py-3">Tên</th>
                    <th class="px-6 py-3">Danh mục</th>
                    <th class="px-6 py-3">Giá</th>
                    <th class="px-6 py-3">Tồn kho</th>
                    <th class="px-6 py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-16 h-16 object-cover">
                        </td>
                        <td class="px-6 py-4">{{ $product->name }}</td>
                        <td class="px-6 py-4">{{ $product->category->name }}</td>
                        <td class="px-6 py-4">{{ number_format($product->price) }}₫</td>
                        <td class="px-6 py-4">{{ $product->stock }}</td>
                        <td class="px-6 py-4">
                            <!-- Sửa -->
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="text-blue-600">Sửa</a>
                            
                            <!-- Xóa -->
                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Xác nhận xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Phân trang -->
        <div class="px-6 py-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
```

### 📄 Form tạo/sửa: `resources/views/admin/products/create.blade.php`

```blade
@extends('layouts.admin')

@section('title', 'Thêm Sản phẩm')

@section('content')
<div class="container mx-auto px-6">
    <h2 class="text-2xl font-semibold my-6">Thêm Sản phẩm mới</h2>
    
    <!-- Hiển thị lỗi validation -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('admin.products.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="bg-white shadow-md rounded px-8 py-6">
        @csrf
        
        <!-- Tên sản phẩm -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">
                Tên sản phẩm *
            </label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name') }}"
                   class="w-full px-3 py-2 border rounded"
                   required>
        </div>
        
        <!-- Mô tả -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Mô tả</label>
            <textarea name="description" 
                      rows="4"
                      class="w-full px-3 py-2 border rounded">{{ old('description') }}</textarea>
        </div>
        
        <!-- Giá -->
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Giá gốc *</label>
                <input type="number" 
                       name="price" 
                       value="{{ old('price') }}"
                       step="0.01"
                       class="w-full px-3 py-2 border rounded"
                       required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Giá khuyến mãi</label>
                <input type="number" 
                       name="sale_price" 
                       value="{{ old('sale_price') }}"
                       step="0.01"
                       class="w-full px-3 py-2 border rounded">
            </div>
        </div>
        
        <!-- Danh mục -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Danh mục *</label>
            <select name="category_id" 
                    class="w-full px-3 py-2 border rounded"
                    required>
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Tồn kho -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Tồn kho *</label>
            <input type="number" 
                   name="stock" 
                   value="{{ old('stock', 0) }}"
                   class="w-full px-3 py-2 border rounded"
                   required>
        </div>
        
        <!-- Hình ảnh -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Hình ảnh</label>
            <input type="file" 
                   name="image" 
                   accept="image/*"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <!-- Buttons -->
        <div class="flex items-center justify-between">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Lưu
            </button>
            <a href="{{ route('admin.products.index') }}" 
               class="text-gray-600">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
```

---

## 7. LUỒNG XỬ LÝ

### 🔄 Luồng CRUD đầy đủ

```
1. User truy cập: /admin/products
   ↓
2. Middleware kiểm tra:
   - Đã đăng nhập? (auth)
   - Là admin? (is_admin)
   ↓
3. Route dispatch đến: ProductController@index
   ↓
4. Controller:
   - Query database: Product::with('category')->paginate(20)
   - Return view: admin.products.index
   ↓
5. View render HTML với dữ liệu
   ↓
6. User nhấn "Thêm mới"
   ↓
7. GET /admin/products/create
   → ProductController@create
   → Hiển thị form
   ↓
8. User điền form và submit
   ↓
9. POST /admin/products
   → ProductController@store
   → Validation
   → Upload file (nếu có)
   → Product::create($data)
   → Redirect về index với thông báo thành công
```

### 🔐 Bảo mật

```php
// 1. Middleware bảo vệ routes
Route::middleware(['auth', 'is_admin'])

// 2. Validation dữ liệu đầu vào
$request->validate([...])

// 3. Mass Assignment Protection
protected $fillable = ['name', 'price', ...];

// 4. CSRF Token (tự động)
@csrf trong form

// 5. XSS Protection (Blade tự động)
{{ $product->name }}  // Auto escape HTML
{!! $html !!}         // Không escape (cẩn thận!)
```

---

## 📚 TÀI LIỆU THAM KHẢO

### Các khái niệm quan trọng cần học:

1. **MVC Pattern**: Model - View - Controller
2. **Eloquent ORM**: Làm việc với database
3. **Blade Template**: Template engine của Laravel
4. **Middleware**: Lớp xử lý giữa request và response
5. **Validation**: Kiểm tra dữ liệu đầu vào
6. **Route Model Binding**: Tự động inject model
7. **File Storage**: Upload và quản lý file
8. **Pagination**: Phân trang dữ liệu
9. **Flash Session**: Thông báo tạm thời
10. **CSRF Protection**: Bảo mật form

### Các file quan trọng cần xem:

```
📁 Routes
- routes/web.php (Định nghĩa tất cả routes)

📁 Controllers
- app/Http/Controllers/Admin/*.php

📁 Models
- app/Models/Product.php
- app/Models/Order.php
- app/Models/User.php
- app/Models/Category.php

📁 Middleware
- app/Http/Middleware/IsAdmin.php

📁 Views
- resources/views/admin/**/*.blade.php
- resources/views/layouts/admin.blade.php

📁 Migrations
- database/migrations/*.php

📁 Config
- config/auth.php (Authentication)
- config/filesystems.php (File storage)
```

---

## 🎯 BÀI TẬP THỰC HÀNH

### Cấp độ 1: Hiểu code
1. Đọc và hiểu luồng xử lý của ProductController
2. Trace code từ route → controller → model → view
3. Hiểu cách middleware bảo vệ routes

### Cấp độ 2: Sửa đổi
1. Thêm trường mới vào Product (vd: brand, weight)
2. Thêm filter/search trong danh sách sản phẩm
3. Tùy chỉnh giao diện admin

### Cấp độ 3: Tạo mới
1. Tạo module quản lý Coupons (mã giảm giá)
2. Tạo module quản lý Reviews (đánh giá sản phẩm)
3. Tạo dashboard với biểu đồ thống kê

---

## ❓ TROUBLESHOOTING

### Lỗi 403 khi vào /admin
```
→ Kiểm tra user có is_admin = 1 không
→ Kiểm tra đã đăng nhập chưa
```

### Lỗi upload file
```
→ Chạy: php artisan storage:link
→ Kiểm tra quyền thư mục storage/
```

### Lỗi validation không hiện
```
→ Kiểm tra @if($errors->any()) trong view
→ Xem session có flash message không
```

---

**Chúc bạn học tốt! 🚀**
