<!DOCTYPE html>
<html lang="en">

<head>
  @include('home.css')
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LFCShop | My Cart</title>

  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

  <style>
    body {
      font-family: "Poppins", "Battambang", sans-serif;
      background: linear-gradient(180deg, #0F6B63, #4FA7A5, #70B2B2, #A2D3D6);
      background-attachment: fixed;
      color: #fff;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    .div_deg {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 70px 0;
      animation: fadeIn 1s ease-in;
    }

    table {
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      overflow: hidden;
      width: 85%;
      color: #fff;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    th {
      background: rgba(255, 212, 59, 0.9);
      color: #0F6B63;
      font-size: 18px;
      text-transform: uppercase;
      padding: 12px;
    }

    td {
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      text-align: center;
      padding: 15px;
    }

    td img {
      border-radius: 12px;
      transition: transform 0.3s ease;
    }

    td img:hover {
      transform: scale(1.05);
    }

    .qty-btn {
      background-color: #FFD43B;
      border: none;
      color: #0F6B63;
      padding: 6px 10px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.2s;
    }

    .qty-btn:hover {
      background-color: #f5c518;
      transform: scale(1.1);
    }

    .qty-display {
      font-weight: 600;
      padding: 0 8px;
      color: #fff;
    }

    .cart_value {
      text-align: center;
      padding: 30px;
      animation: fadeInUp 1s ease;
    }

    .cart_value h3 {
      color: #fff;
      font-size: 24px;
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .text-success {
      color: #A4FFB0;
      font-weight: bold;
    }

    .order_deg {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-bottom: 80px;
    }

    .div_gap {
      padding: 12px;
    }

    label {
      width: 160px;
      display: inline-block;
      color: #fff;
      font-weight: 500;
    }

    input,
    textarea {
      border-radius: 8px;
      border: none;
      padding: 8px 10px;
      width: 260px;
      outline: none;
      font-size: 15px;
      color: #0F6B63;
    }

    textarea {
      height: 80px;
      resize: none;
    }

    .payment-buttons {
      margin-top: 25px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 18px;
      /* space between buttons */
      flex-wrap: nowrap;
      /* keep them on one row */
    }

    .btn-pay {
      display: inline-flex;
      /* make both behave the same */
      align-items: center;
      justify-content: center;
      padding: 14px 26px;
      border-radius: 999px;
      font-weight: 600;
      font-size: 15px;
      border: none;
      color: #fff;
      text-decoration: none;
      cursor: pointer;
      box-shadow: 0 10px 22px rgba(0, 0, 0, 0.25);
      transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
    }

    /* colors */
    .btn-cash {
      background: linear-gradient(135deg, #21b457, #0f8a3f);
    }

    .btn-card {
      background: linear-gradient(135deg, #1f7bff, #1156d6);
    }

    .btn-aba {
      background: linear-gradient(135deg, #0a7ccf, #05518e);
    }

    .btn-pay:hover {
      transform: translateY(-1px);
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.3);
    }

    .btn-pay:active {
      transform: translateY(1px) scale(0.98);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
    }


    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>
  <div class="hero_area">@include('home.header')</div>

  <div class="div_deg">
    <table>
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Image</th>
        <th>Quantity</th>
        <th>Remove</th>
      </tr>

      @php $value = 0; $savings = 0; @endphp

      @foreach($cart as $cart)
      <tr>
        <td>{{ $cart->product->title }}</td>
        <td>
          @if($cart->product->discount_price)
          <span style="color:#FFD43B;">${{ $cart->product->discount_price }}</span>
          <del style="opacity:0.7">${{ $cart->product->price }}</del>
          @php
          $value += $cart->product->discount_price * $cart->quantity;
          $savings += ($cart->product->price - $cart->product->discount_price) * $cart->quantity;
          @endphp
          @else
          ${{ $cart->product->price }}
          @php $value += $cart->product->price * $cart->quantity; @endphp
          @endif
        </td>

        <td><img width="120" src="/products/{{ $cart->product->image }}"></td>

        <td>
          <div class="quantity-form" data-id="{{ $cart->id }}">
            <button type="button" class="qty-btn decrease">−</button>
            <span class="qty-display">{{ $cart->quantity }}</span>
            <button type="button" class="qty-btn increase">+</button>
          </div>
        </td>

        <td>
          <a class="btn btn-danger btn-sm remove-btn" href="{{ url('delete_cart', $cart->id) }}">
            Remove
          </a>
        </td>
      </tr>
      @endforeach
    </table>
  </div>

  <div class="cart_value">
    <h3>Total Value of Cart is : ${{ $value }}</h3>
    @if($savings > 0)
    <p class="text-success">You saved ${{ $savings }} on this order!</p>
    @endif
  </div>

  <div class="order_deg">
    <form action="{{ url('confirm_order') }}" method="POST">
      @csrf

      <div class="div_gap">
        <label>Receiver Name</label>
        <input type="text" name="name" value="{{ auth()->user()?->name }}">
      </div>

      <div class="div_gap">
        <label>Receiver Address</label>
        <textarea name="address">{{ auth()->user()?->address }}</textarea>
      </div>

      <div class="div_gap">
        <label>Receiver Phone</label>
        <input type="text" name="phone" value="{{ auth()->user()?->phone }}">
      </div>

      <div class="payment-buttons">
        <input class="btn-pay btn-cash" type="submit" value="💵 Cash On Delivery">
        <a class="btn-pay btn-card" href="{{ url('stripe', $value) }}">💳 Pay Using Card</a>
        <!-- <button type="button" id="checkout_button" class="btn-pay btn-aba">🏦 Pay with ABA</button> -->
      </div>
    </form>

  </div>

  @include('home.footer')

  <!-- ✅ SweetAlert2 & jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(function() {
      $('#checkout_button').on('click', async function() {
        const payload = {
          amount: "{{ number_format($value, 2, '.', '') }}",
          receiver_name: $('input[name="name"]').val(),
          receiver_phone: $('input[name="phone"]').val(),
          receiver_address: $('textarea[name="address"]').val(),
          cart: [] // (ជាជម្រើស) អាចបញ្ចូល cart items id/json
        };

        Swal.fire({
          icon: 'info',
          title: 'កំពុងភ្ជាប់ទៅ ABA…',
          showConfirmButton: false,
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });

        try {
          const resp = await fetch("{{ route('payway.purchase') }}", {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
          });
          const data = await resp.json();
          if (data.ok && data.payment_url) window.location.href = data.payment_url;
          else Swal.fire({
            icon: 'error',
            title: 'Payment error',
            text: data.message || 'Cannot start payment.'
          });
        } catch (e) {
          Swal.fire({
            icon: 'error',
            title: 'Network error',
            text: 'Please try again.'
          });
          console.error(e);
        }
      });

      /* ✅ Update Quantity */
      $('.qty-btn').on('click', function() {
        const $btn = $(this);
        const $parent = $btn.closest('.quantity-form');
        const id = $parent.data('id');
        const action = $btn.hasClass('increase') ? 'increase' : 'decrease';
        const $display = $parent.find('.qty-display');

        $.ajax({
          url: '/update_cart/' + id,
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            action
          },
          success: function(response) {
            $display.text(response.quantity);

            $('.cart_value h3').text('Total Value of Cart is : $' + response.total);
            if (parseFloat(response.savings) > 0) {
              $('.cart_value p.text-success').text('You saved $' + response.savings + ' on this order!');
            } else {
              $('.cart_value p.text-success').text('');
            }

            updateCartCount();

            Swal.fire({
              icon: 'success',
              title: 'Cart Updated!',
              text: response.message,
              showConfirmButton: false,
              timer: 1200
            });
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'បរាជ័យក្នុងការអាប់ដេត',
              text: 'សូមសាកល្បងម្ដងទៀត!'
            });
          }
        });
      });

      /* 🗑 Remove Confirmation */
      $('.remove-btn').on('click', function(e) {
        e.preventDefault();
        const link = $(this).attr('href');
        Swal.fire({
          title: 'លុបទំនិញមែនទេ?',
          text: 'ទំនិញនេះនឹងត្រូវដកចេញពីកន្ត្រក!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'បាទ/ចាស លុប!'
        }).then((result) => {
          if (result.isConfirmed) window.location.href = link;
        });
      });

      /* 🧾 Update Cart Summary */
      function updateCartSummary() {
        $.get('/cart/summary', function(data) {
          $('.cart_value h3').text('Total Value of Cart is : $' + data.total);
          if (data.savings > 0) {
            $('.cart_value p.text-success').text('You saved $' + data.savings + ' on this order!');
          } else {
            $('.cart_value p.text-success').text('');
          }
        });
      }

      /* ✅ Update Header Cart Count */
      function updateCartCount() {
        $.get('/cart/count', function(data) {
          const $cartCount = $('#cart_count');
          $cartCount.text(data.count).addClass('count-glow');
          setTimeout(() => $cartCount.removeClass('count-glow'), 800);
        });
      }

    });
  </script>

  <!-- 🟡 Glow effect CSS -->
  <style>
    #cart_count.count-glow {
      animation: glowPulse 0.8s ease-in-out;
    }

    @keyframes glowPulse {
      0% {
        box-shadow: 0 0 0px 0px rgba(255, 215, 0, 0.8);
        transform: scale(1);
      }

      50% {
        box-shadow: 0 0 15px 5px rgba(255, 215, 0, 1);
        transform: scale(1.2);
      }

      100% {
        box-shadow: 0 0 0px 0px rgba(255, 215, 0, 0.8);
        transform: scale(1);
      }
    }
  </style>


  <!-- 🟡 Cart Count Glow CSS -->
  <style>
    #cart_count.count-glow {
      animation: glowPulse 0.8s ease-in-out;
    }

    @keyframes glowPulse {
      0% {
        box-shadow: 0 0 0px 0px rgba(255, 215, 0, 0.8);
        transform: scale(1);
      }

      50% {
        box-shadow: 0 0 15px 5px rgba(255, 215, 0, 1);
        transform: scale(1.2);
      }

      100% {
        box-shadow: 0 0 0px 0px rgba(255, 215, 0, 0.8);
        transform: scale(1);
      }
    }
  </style>


  <!-- 🟡 Add this CSS glow animation -->
  <style>
    #cart_count.count-glow {
      animation: glowPulse 0.8s ease-in-out;
    }

    @keyframes glowPulse {
      0% {
        box-shadow: 0 0 0px 0px rgba(255, 215, 0, 0.8);
        transform: scale(1);
      }

      50% {
        box-shadow: 0 0 15px 5px rgba(255, 215, 0, 1);
        transform: scale(1.2);
      }

      100% {
        box-shadow: 0 0 0px 0px rgba(255, 215, 0, 0.8);
        transform: scale(1);
      }
    }
  </style>