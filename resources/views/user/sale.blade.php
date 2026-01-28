<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sản phẩm giảm giá - Stylish</title>
  <link rel="stylesheet" href="{{ asset('user/css/vendor.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('user/css/style.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,900;1,900&family=Source+Sans+Pro:wght@400;600;700;900&display=swap"
    rel="stylesheet">
  
  <style>
    .sale-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: #ff4444;
      color: white;
      padding: 5px 12px;
      border-radius: 4px;
      font-weight: bold;
      font-size: 12px;
      z-index: 10;
    }
    .original-price {
      text-decoration: line-through;
      color: #999;
      font-size: 14px;
      margin-right: 8px;
    }
    .sale-price {
      color: #ff4444;
      font-weight: bold;
      font-size: 18px;
    }
    .discount-percent {
      background: #ff4444;
      color: white;
      padding: 2px 8px;
      border-radius: 3px;
      font-size: 12px;
      margin-left: 8px;
    }
  </style>
</head>

<body>
  {{-- Preloader --}}
  <div class="preloader" style="position: fixed;top:0;left:0;width: 100%;height: 100%;background-color: #fff;display: flex;align-items: center;justify-content: center;z-index: 9999;">
    <svg version="1.1" id="L4" width="100" height="100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
      viewBox="0 0 50 100" enable-background="new 0 0 0 0" xml:space="preserve">
      <circle fill="#111" stroke="none" cx="6" cy="50" r="6">
        <animate
          attributeName="opacity"
          dur="1s"
          values="0;1;0"
          repeatCount="indefinite"
          begin="0.1" />
      </circle>
      <circle fill="#111" stroke="none" cx="26" cy="50" r="6">
        <animate
          attributeName="opacity"
          dur="1s"
          values="0;1;0"
          repeatCount="indefinite"
          begin="0.2" />
      </circle>
      <circle fill="#111" stroke="none" cx="46" cy="50" r="6">
        <animate
          attributeName="opacity"
          dur="1s"
          values="0;1;0"
          repeatCount="indefinite"
          begin="0.3" />
      </circle>
    </svg>
  </div>

  @include('partials.header')

  {{-- Page Header --}}
  <section class="py-5 bg-light">
    <div class="container">
      <div class="text-center">
        <h1 class="display-4 fw-bold mb-3">🔥 Sản phẩm giảm giá</h1>
        <p class="lead text-muted">Khám phá các sản phẩm đang có ưu đãi đặc biệt</p>
      </div>
    </div>
  </section>

  {{-- Sale Products Section --}}
  <section id="sale-products" class="product-store py-5">
    <div class="container-md">
      @if(isset($products) && count($products) > 0)
        <div class="product-content padding-small">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @foreach($products as $product)
              @php
                $id = $product->sku ?? $product->id;
                $title = $product->name ?? 'Sản phẩm';
                $price = $product->price ?? 0;
                $salePrice = $product->sale_price ?? 0;
                
                // Calculate discount percentage
                $discountPercent = 0;
                if ($price > 0 && $salePrice > 0) {
                    $discountPercent = round((($price - $salePrice) / $price) * 100);
                }
                
                // Resolve image via helper
                $image = \App\Helpers\ImageHelper::productImageUrl(null, $product);
              @endphp
              
              <div class="col mb-4">
                <div class="product-card position-relative">
                  <div class="card-img position-relative">
                    {{-- Sale Badge --}}
                    @if($discountPercent > 0)
                      <span class="sale-badge">-{{ $discountPercent }}%</span>
                    @endif
                    
                    <a href="{{ route('product.show', $id) }}">
                      <img src="{{ $image }}" alt="{{ $title }}" class="product-image img-fluid">
                    </a>
                    
                    <div class="cart-concern position-absolute d-flex justify-content-center">
                      <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                        <a href="#" data-sku="{{ $id }}" data-name="{{ e($title) }}" data-price="{{ $salePrice }}" class="btn btn-light ajax-add-cart">
                          <svg class="shopping-carriage">
                            <use xlink:href="#shopping-carriage"></use>
                          </svg>
                        </a>
                        <a href="{{ route('product.show', $id) }}" class="btn btn-light">
                          <svg class="quick-view">
                            <use xlink:href="#quick-view"></use>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  
                  <div class="card-detail mt-3">
                    <h3 class="card-title fs-6 fw-normal m-0 mb-2">
                      <a href="{{ route('product.show', $id) }}">{{ $title }}</a>
                    </h3>
                    <div class="d-flex align-items-center flex-wrap">
                      <span class="original-price">${{ number_format($price, 2) }}</span>
                      <span class="sale-price">${{ number_format($salePrice, 2) }}</span>
                      @if($discountPercent > 0)
                        <span class="discount-percent">-{{ $discountPercent }}%</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @else
        {{-- No sale products message --}}
        <div class="text-center py-5">
          <svg width="120" height="120" class="mb-4" fill="currentColor" opacity="0.3">
            <use xlink:href="#shopping-bag"></use>
          </svg>
          <h3 class="mb-3">Hiện tại chưa có sản phẩm giảm giá</h3>
          <p class="text-muted mb-4">Vui lòng quay lại sau để không bỏ lỡ các ưu đãi hấp dẫn!</p>
          <a href="{{ url('/') }}" class="btn btn-dark btn-medium text-uppercase">Xem tất cả sản phẩm</a>
        </div>
      @endif
    </div>
  </section>

  @include('partials.add_toast')
  
  <footer id="footer" class="py-5 border-top">
    <div class="container-lg">
      <div class="row">
        {{-- Cột 1: Về chúng tôi --}}
        <div class="col-lg-2 col-md-4 col-sm-6 pb-3">
          <div class="footer-menu">
            <h5 class="widget-title pb-2">Về chúng tôi</h5>
            <ul class="menu-list list-unstyled">
              <li class="pb-2">
                <a href="{{ url('/') }}">Giới thiệu</a>
              </li>
              <li class="pb-2">
                <a href="#">Lịch sử hình thành</a>
              </li>
              <li class="pb-2">
                <a href="#">Đội ngũ</a>
              </li>
              <li class="pb-2">
                <a href="#">Tuyển dụng</a>
              </li>
              <li class="pb-2">
                <a href="#">Blog</a>
              </li>
            </ul>
          </div>
        </div>

        {{-- Cột 2: Hỗ trợ khách hàng --}}
        <div class="col-lg-2 col-md-4 col-sm-6 pb-3">
          <div class="footer-menu">
            <h5 class="widget-title pb-2">Hỗ trợ khách hàng</h5>
            <ul class="menu-list list-unstyled">
              <li class="pb-2">
                <a href="#">Theo dõi đơn hàng</a>
              </li>
              <li class="pb-2">
                <a href="#">Chính sách đổi trả</a>
              </li>
              <li class="pb-2">
                <a href="#">Chính sách bảo mật</a>
              </li>
              <li class="pb-2">
                <a href="#">Hướng dẫn mua hàng</a>
              </li>
              <li class="pb-2">
                <a href="#">Câu hỏi thường gặp</a>
              </li>
            </ul>
          </div>
        </div>

        {{-- Cột 3: Danh mục sản phẩm --}}
        <div class="col-lg-2 col-md-4 col-sm-6 pb-3">
          <div class="footer-menu">
            <h5 class="widget-title pb-2">Danh mục sản phẩm</h5>
            <ul class="menu-list list-unstyled">
              <li class="pb-2">
                <a href="#">Giày nam</a>
              </li>
              <li class="pb-2">
                <a href="#">Giày nữ</a>
              </li>
              <li class="pb-2">
                <a href="#">Giày thể thao</a>
              </li>
              <li class="pb-2">
                <a href="#">Giày cao gót</a>
              </li>
              <li class="pb-2">
                <a href="#">Phụ kiện</a>
              </li>
            </ul>
          </div>
        </div>

        {{-- Cột 4: Tài khoản --}}
        <div class="col-lg-2 col-md-4 col-sm-6 pb-3">
          <div class="footer-menu">
            <h5 class="widget-title pb-2">Tài khoản</h5>
            <ul class="menu-list list-unstyled">
              <li class="pb-2">
                <a href="{{ route('login') }}">Đăng nhập</a>
              </li>
              <li class="pb-2">
                <a href="{{ route('register') }}">Đăng ký</a>
              </li>
              <li class="pb-2">
                <a href="{{ route('account') }}">Tài khoản của tôi</a>
              </li>
              <li class="pb-2">
                <a href="/cart">Giỏ hàng</a>
              </li>
              <li class="pb-2">
                <a href="#">Sản phẩm yêu thích</a>
              </li>
            </ul>
          </div>
        </div>

        {{-- Cột 5: Liên hệ --}}
        <div class="col-lg-4 col-md-8 col-sm-12 pb-3">
          <div class="footer-menu">
            <h5 class="widget-title pb-3">Liên hệ với chúng tôi</h5>
            <div class="footer-contact-text">
              <p class="mb-2">
                <strong>Địa chỉ:</strong><br>
                Stylish Online Store, Yên Nghĩa, Hà Đông - Hà Nội
              </p>
              <p class="mb-2">
                <strong>Hotline:</strong> <a href="tel:+84123456789">(+84) 123 456 789</a>
              </p>
              <p class="mb-2">
                <strong>Email:</strong> <a href="mailto:contact@stylish.vn" class="text-hover">contact@stylish.vn</a>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <p>© Bản quyền Stylish 2023.</p>
        </div>
        <div class="col-md-6 text-lg-end">
          <p>Free HTML by <a href="https://templatesjungle.com/" target="_blank">TemplatesJungle</a><br> Distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a> </p>
        </div>
      </div>
    </div>
  </footer>

  <script src="{{ asset('user/js/jquery-1.11.0.min.js') }}"></script>
  <script src="{{ asset('user/js/plugins.js') }}"></script>
  <script src="{{ asset('user/js/script.js') }}"></script>
</body>

</html>
