<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Nữ - Sản phẩm</title>
  <link rel="stylesheet" href="{{ asset('user/css/vendor.css') }}">
  <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
</head>
<body>
  @include('partials.header')
  <div class="container-lg py-5">
    <h1 class="mb-4">Nữ</h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      @for($i=1;$i<=9;$i++)
        <div class="col">
          <div class="product-card position-relative p-3 border rounded h-100">
            <a href="{{ route('product.show', 'women-'.$i) }}" class="d-block mb-2">
              <img src="{{ asset('user/images/card-item'.((($i+3)%10)+1).'.jpg') }}" alt="sản phẩm" class="img-fluid" style="height:180px;object-fit:cover;width:100%">
            </a>
            <h3 class="fs-6 mb-2">
              <a href="{{ route('product.show', 'women-'.$i) }}" class="text-dark text-decoration-none">Sản phẩm nữ {{ $i }}</a>
            </h3>
            <div class="d-flex justify-content-between align-items-center">
              <div class="fw-bold">$89</div>
              <a href="#" class="btn btn-sm btn-black ajax-add-cart"
                 data-sku="women-{{ $i }}"
                 data-name="Sản phẩm nữ {{ $i }}"
                 data-price="89"
                 data-image="user/images/card-item{{ ((($i+3)%10)+1) }}.jpg">Thêm vào giỏ</a>
            </div>
          </div>
        </div>
      @endfor
    </div>
  </div>
  @include('partials.add_toast')

  <script src="{{ asset('user/js/jquery-1.11.0.min.js') }}"></script>
  <script src="{{ asset('user/js/plugins.js') }}"></script>
  <script src="{{ asset('user/js/script.js') }}"></script>
</body>
</html>
