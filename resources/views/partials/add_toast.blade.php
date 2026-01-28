<div id="addToast" data-status="{{ e(session('status') ?? '') }}" role="status" aria-live="polite">
  <div class="icon">✓</div>
  <div class="msg">Sản phẩm đã được thêm</div>
  <button class="close-toast" aria-label="Close" onclick="document.getElementById('addToast').style.display='none'">✕</button>
</div>

<style>
  #addToast {
    position: fixed;
    top: 16px;
    right: 16px;
    background: #e6ffed;
    border: 1px solid #c6f6d5;
    color: #0f5132;
    padding: 12px 16px;
    border-radius: 8px;
    box-shadow: 0 6px 20px rgba(15,81,50,0.12);
    display: none;
    align-items: center;
    gap: 12px;
    z-index: 12000;
    min-width: 220px;
    font-weight:700;
  }
  #addToast .icon { width:28px;height:28px;background:#0f5132;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px; }
  #addToast .close-toast { background: transparent; border: none; color: #0f5132; font-weight:700; cursor:pointer }
</style>

<script>
  (function(){
    // Flash-from-session support
    var t = document.getElementById('addToast');
    var status = t ? t.getAttribute('data-status') : '';
    if (status) {
      t.querySelector('.msg').textContent = status;
      t.style.display = 'flex';
      setTimeout(function(){ t.style.display = 'none'; }, 3500);
    }
  })();

  (function(){
    function showToast(message){
      var t = document.getElementById('addToast');
      if (!t) return;
      t.querySelector('.msg').textContent = message;
      t.style.display = 'flex';
      setTimeout(function(){ t.style.display = 'none'; }, 3000);
    }

    function postJson(url, data) {
      var token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : null;
      var headers = {'Content-Type': 'application/json'};
      if (token) headers['X-CSRF-TOKEN'] = token;
      return fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: headers,
        body: JSON.stringify(data)
      }).then(function(r){ return r.json(); });
    }

    document.addEventListener('click', function(e){
      var el = e.target.closest && e.target.closest('.ajax-add-cart');
      if (!el) return;
      e.preventDefault();
      var sku = el.getAttribute('data-sku');
      var name = el.getAttribute('data-name');
      var price = el.getAttribute('data-price');
      var image = el.getAttribute('data-image');

      postJson("{{ url('/cart/add') }}", { id: sku, name: name, price: price, qty: 1, image: image })
        .then(function(json){
          if (json && json.status === 'success') {
            showToast(json.message || 'Đã thêm vào giỏ hàng');
            // update cart count badge if present
            if (json.cart_count) {
              var badge = document.querySelector('.cart-count');
              if (badge) badge.textContent = json.cart_count;
            }
          } else if (json && json.message) {
            showToast(json.message);
          } else {
            showToast('Đã có lỗi, vui lòng thử lại');
          }
        }).catch(function(){
          showToast('Đã thêm vào giỏ hàng');
        });
    });
  })();
</script>
