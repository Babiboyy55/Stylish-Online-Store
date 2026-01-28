<!DOCTYPE html>
<html lang="vi">

<head>
  <title>@yield('title', 'Stylish - Cửa hàng giày trực tuyến')</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="author" content="TemplatesJungle">
  <meta name="keywords" content="Cửa hàng trực tuyến, giày dép">
  <meta name="description" content="Stylish - Mẫu cửa hàng giày trực tuyến">

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

  {{-- Content from child views --}}
  @yield('content')

  <!-- Site scripts -->
  <script src="{{ asset('user/js/jquery-1.11.0.min.js') }}"></script>
  <script src="{{ asset('user/js/plugins.js') }}"></script>
  <script src="{{ asset('user/js/script.js') }}"></script>
  @stack('scripts')

  {{-- Tidio Chat Widget - sẽ thêm sau --}}

</body>

</html>