<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('user/css/vendor.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('user/css/style.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,900;1,900&family=Source+Sans+Pro:wght@400;600;700;900&display=swap"
    rel="stylesheet">
</head>

<body>
  {{-- SVG symbols moved to header partial --}}
  <!-- Loader 4 -->

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

  {{-- search overlay moved to header partial --}}

  <!-- quick view -->
  @include('partials.header')

  <section id="intro" class="position-relative mt-4">
    <div class="container-lg">
      <div class="swiper main-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="card d-flex flex-row align-items-end border-0 large jarallax-keep-img">
              <img src="{{ asset('user/images/card-image1.jpg') }}" alt="shoes" class="img-fluid jarallax-img">
              <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                <h2 class="card-title display-3 light">Giày kiểu dáng nữ</h2>
                <a href="#"
                  class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Mua ngay</a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="row g-4">
              <div class="col-lg-12 mb-4">
                <div class="card d-flex flex-row align-items-end border-0 jarallax-keep-img">
                  <img src="{{ asset('user/images/card-image2.jpg') }}"" alt=" shoes" class="img-fluid jarallax-img">
                  <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                    <h2 class="card-title style-2 display-4 light">Đồ thể thao</h2>
                    <a href="#"
                      class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Mua ngay</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="card d-flex flex-row align-items-end border-0 jarallax-keep-img">
                  <img src="{{ asset('user/images/card-image3.jpg') }}"" alt=" shoes" class="img-fluid jarallax-img">
                  <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                    <h2 class="card-title style-2 display-4 light">Giày thời trang</h2>
                    <a href="#"
                      class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Mua ngay</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card d-flex flex-row align-items-end border-0 large jarallax-keep-img">
              <img src="{{ asset('user/images/card-image4.jpg') }}"" alt=" shoes" class="img-fluid jarallax-img">
              <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                <h2 class="card-title display-3 light">Giày kiểu dáng nam</h2>
                <a href="index.html"
                  class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Mua ngay</a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="row g-4">
              <div class="col-lg-12 mb-4">
                <div class="card d-flex flex-row align-items-end border-0 jarallax-keep-img">
                  <img src="{{ asset('user/images/card-image5.jpg') }}"" alt=" shoes" class="img-fluid jarallax-img">
                  <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                    <h2 class="card-title style-2 display-4 light">Giày nam</h2>
                    <a href="index.html"
                      class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Mua ngay</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="card d-flex flex-row align-items-end border-0 jarallax-keep-img">
                  <img src="{{ asset('user/images/card-image6.jpg') }}"" alt=" shoes" class="img-fluid jarallax-img">
                  <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                    <h2 class="card-title style-2 display-4 light">Giày nữ</h2>
                    <a href="index.html"
                      class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Mua ngay</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </section>
  <section class="discount-coupon py-2 my-2 py-md-5 my-md-5">
    <div class="container">
      <a href="{{ route('sale') }}" class="text-decoration-none">
        <div class="bg-gray coupon position-relative p-5">
          <div class="bold-text position-absolute">Giảm 10%</div>
          <div class="row justify-content-between align-items-center">
            <div class="col-lg-7 col-md-12 mb-3">
              <div class="coupon-header">
                <h2 class="display-7">Mã giảm 10%</h2>
                <p class="m-0">Xem ngay các sản phẩm đang giảm giá hấp dẫn!</p>
              </div>
            </div>
            <div class="col-lg-3 col-md-12">
              <div class="btn-wrap">
                <span class="btn btn-black btn-medium text-uppercase hvr-sweep-to-right">Xem ngay</span>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </section>
  <section id="featured-products" class="product-store">
    <div class="container-md">
      <div class="display-header d-flex align-items-center justify-content-between">
        <h2 class="section-title text-uppercase">Sản phẩm nổi bật</h2>
        <div class="btn-right">
          <a href="index.html" class="d-inline-block text-uppercase text-hover fw-bold">Xem tất cả</a>
        </div>
      </div>
      <div class="product-content padding-small">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
          @php
          // Accept either a collection keyed by numeric id or associative array (legacy)
          $list = $products ?? (isset($products) ? $products : null);
          @endphp
          @if(isset($products) && count($products))
          @foreach($products as $product)
          @php
          $id = $product->sku ?? $product->id;
          $title = $product->name ?? 'Sản phẩm';
          $price = $product->price ?? 0;

          // Resolve image via helper
          $image = \App\Helpers\ImageHelper::productImageUrl(null, $product);
          @endphp
          <div class="col mb-4">
            <div class="product-card position-relative">
              <div class="card-img">
                <a href="{{ route('product.show', $id) }}">
                  <img src="{{ $image }}" alt="product-item" class="product-image img-fluid">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="#" data-sku="{{ $id }}" data-name="{{ e($title) }}" data-price="{{ $price }}" class="btn btn-light ajax-add-cart">
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
                <!-- cart-concern -->
              </div>
              <div class="card-detail d-flex justify-content-between align-items-center mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ route('product.show', $id) }}">{{ $title }}</a>
                </h3>
                <span class="card-price fw-bold">${{ number_format($price, 2) }}</span>
              </div>
            </div>
          </div>
          @endforeach
          @else
          {{-- fallback: keep static items if DB not seeded --}}
          <div class="col mb-4">No products available.</div>
          @endif
        </div>
      </div>
    </div>
  </section>
  <section id="collection-products" class="py-2 my-2 py-md-5 my-md-5">
    <div class="container-md">
      <div class="row">
        <div class="col-lg-6 col-md-6 mb-4">
          <div class="collection-card card border-0 d-flex flex-row align-items-end jarallax-keep-img">
            <img src="{{ asset('user/images/collection-item1.jpg') }}"" alt=" product-item" class="border-rounded-10 img-fluid jarallax-img">
            <div class="card-detail p-3 m-3 p-lg-5 m-lg-5">
              <h3 class="card-title display-3">
                <a href="#">Bộ sưu tập Tối giản</a>
              </h3>
              <a href="index.html" class="text-uppercase mt-3 d-inline-block text-hover fw-bold">Mua ngay</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="collection-card card border-0 d-flex flex-row jarallax-keep-img">
            <img src="{{ asset('user/images/collection-item2.jpg') }}"" alt=" product-item" class="border-rounded-10 img-fluid jarallax-img">
            <div class="card-detail p-3 m-3 p-lg-5 m-lg-5">
              <h3 class="card-title display-3">
                <a href="#">Bộ sưu tập Sneaker</a>
              </h3>
              <a href="index.html" class="text-uppercase mt-3 d-inline-block text-hover fw-bold">Mua ngay</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="latest-products" class="product-store py-2 my-2 py-md-5 my-md-5 pt-0">
    <div class="container-md">
      <div class="display-header d-flex align-items-center justify-content-between">
        <h2 class="section-title text-uppercase">Sản phẩm mới</h2>
        <div class="btn-right">
          <a href="index.html" class="d-inline-block text-uppercase text-hover fw-bold">Xem tất cả</a>
        </div>
      </div>
      <div class="product-content padding-small">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
          <div class="col mb-4 mb-3">
            <div class="product-card position-relative">
              <div class="card-img">
                <a href="{{ url('/product/p6') }}">
                  <img src="{{ asset('user/images/card-item6.jpg') }}" alt="product-item" class="product-image img-fluid">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p6') }}" class="btn btn-light">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p6') }}" class="btn btn-light">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
                <!-- cart-concern -->
              </div>
              <div class="card-detail d-flex justify-content-between align-items-center mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p6') }}">Giày chạy bộ nam</a>
                </h3>
                <span class="card-price fw-bold">$99</span>
              </div>
            </div>
          </div>
          <div class="col mb-4 mb-3">
            <div class="product-card position-relative">
              <div class="card-img">
                <a href="{{ url('/product/p7') }}">
                  <img src="{{ asset('user/images/card-item7.jpg') }}" alt="product-item" class="product-image img-fluid">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p7') }}" class="btn btn-light">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p7') }}" class="btn btn-light">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
                <!-- cart-concern -->
              </div>
              <div class="card-detail d-flex justify-content-between align-items-center mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p7') }}">Giày chạy bộ nam</a>
                </h3>
                <span class="card-price fw-bold">$99</span>
              </div>
            </div>
          </div>
          <div class="col mb-4 mb-3">
            <div class="product-card position-relative">
              <div class="card-img">
                <a href="{{ url('/product/p8') }}">
                  <img src="{{ asset('user/images/card-item8.jpg') }}" alt="product-item" class="product-image img-fluid">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p8') }}" class="btn btn-light">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p8') }}" class="btn btn-light">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
                <!-- cart-concern -->
              </div>
              <div class="card-detail d-flex justify-content-between align-items-center mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p8') }}">Giày chạy bộ nam</a>
                </h3>
                <span class="card-price fw-bold">$99</span>
              </div>
            </div>
          </div>
          <div class="col mb-4 mb-3">
            <div class="product-card position-relative">
              <div class="card-img">
                <a href="{{ url('/product/p9') }}">
                  <img src="{{ asset('user/images/card-item9.jpg') }}" alt="product-item" class="product-image img-fluid">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p9') }}" class="btn btn-light">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p9') }}" class="btn btn-light">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
                <!-- cart-concern -->
              </div>
              <div class="card-detail d-flex justify-content-between align-items-center mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p9') }}">Giày chạy bộ nam</a>
                </h3>
                <span class="card-price fw-bold">$99</span>
              </div>
            </div>
          </div>
          <div class="col mb-4 mb-3">
            <div class="product-card position-relative">
              <div class="card-img">
                <a href="{{ url('/product/p10') }}">
                  <img src="{{ asset('user/images/card-item10.jpg') }}" alt="product-item" class="product-image img-fluid">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p10') }}" class="btn btn-light">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p10') }}" class="btn btn-light">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
                <!-- cart-concern -->
              </div>
              <div class="card-detail d-flex justify-content-between align-items-center mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p10') }}">Giày chạy bộ nam</a>
                </h3>
                <span class="card-price fw-bold">$99</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
                <a href="{{ route('sale') }}">Giảm giá</a>
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
                <svg width="16" height="16" class="me-2" fill="currentColor">
                  <use xlink:href="#location"></use>
                </svg>
                <strong>Địa chỉ:</strong><br>
                Stylish Online Store, Yên Nghĩa, Hà Đông - Hà Nội
              </p>
              <p class="mb-2">
                <svg width="16" height="16" class="me-2" fill="currentColor">
                  <use xlink:href="#phone"></use>
                </svg>
                <strong>Hotline:</strong> <a href="tel:+84123456789">(+84) 123 456 789</a>
              </p>
              <p class="mb-2">
                <svg width="16" height="16" class="me-2" fill="currentColor">
                  <use xlink:href="#email"></use>
                </svg>
                <strong>Email:</strong> <a href="mailto:contact@stylish.vn" class="text-hover">contact@stylish.vn</a>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="me-3"><i class="fab fa-facebook"></i></a>
                <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="me-3"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <p>© Bản quyền Stylish 2023.</p>
        </div>
        <div class="col-md-6 text-lg-end">
          <p>Free HTML by <a href="https://templatesjungle.com/" target="_blank">TemplatesJungle</a><br> Distributed by <a href="https://themewagon.com" target="blank">ThemeWagon</a> </p>
        </div>
      </div>
    </div>
  </footer>
  @include('partials.add_toast')
  <script src="{{ asset('user/js/jquery-1.11.0.min.js') }}"></script>
  <script src="{{ asset('user/js/plugins.js') }}"></script>
  <script src="{{ asset('user/js/script.js') }}"></script>

  {{-- Tidio Chat Widget - sẽ thêm sau --}}

</body>

</html>