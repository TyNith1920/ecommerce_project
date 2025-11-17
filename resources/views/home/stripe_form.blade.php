<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Stripe Payment | LFCShop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <!-- Stripe -->
  <script src="https://js.stripe.com/v3/"></script>

  <style>
    :root{
      --primary:#0D6EFD;
      --bg1:#0F6B63; --bg2:#4FA7A5; --bg3:#70B2B2; --bg4:#A2D3D6;
    }
    body{
      font-family:"Poppins",system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,"Noto Sans","Apple Color Emoji","Segoe UI Emoji";
      min-height:100vh;
      background: linear-gradient(160deg,var(--bg1),var(--bg2),var(--bg3),var(--bg4));
      background-attachment: fixed;
      display:flex; align-items:center; justify-content:center; padding:24px;
    }
    .pay-card{
      max-width: 560px; width:100%;
      border:0; border-radius:24px;
      box-shadow: 0 18px 50px rgba(0,0,0,.25);
      overflow:hidden;
      backdrop-filter: blur(6px);
    }
    .pay-header{
      background:rgba(255,255,255,.1);
      color:#fff; padding:22px 28px;
    }
    .pay-header h1{ font-size:22px; font-weight:700; margin:0; letter-spacing:.3px; }
    .pay-body{ background:#fff; padding:26px 26px 22px; }
    .total-chip{
      display:inline-flex; align-items:center; gap:8px;
      background:#eef5ff; color:#0b5ed7; font-weight:600;
      border-radius:999px; padding:8px 14px; font-size:14px;
    }
    .StripeElement{
      box-sizing:border-box; height:48px; padding:12px 14px;
      border:1px solid #e5e7eb; border-radius:10px; background:#fafafa;
      transition:all .15s ease; box-shadow: inset 0 1px 0 rgba(0,0,0,.03);
    }
    .StripeElement--focus{ background:#fff; border-color:#b6c8ff; box-shadow:0 0 0 4px rgba(13,110,253,.08); }
    .StripeElement--invalid{ border-color:#dc3545; }
    .hint{ font-size:12px; color:#6b7280; }
    .brand{
      display:flex; align-items:center; gap:10px; color:#e6f7ff;
      font-weight:600; letter-spacing:.5px; opacity:.95;
    }
    .brand .logo{
      width:34px;height:34px;border-radius:9px;background:#00a7ea;display:grid;place-items:center;
      box-shadow:0 6px 16px rgba(0,0,0,.25); font-weight:800; color:#fff;
    }
    .btn-pay{
      height:48px; border-radius:12px; font-weight:700; letter-spacing:.3px;
      display:inline-flex; align-items:center; justify-content:center; gap:8px;
    }
    .badge-test{
      background:#fff1; color:#fff; border:1px solid #fff3; padding:6px 10px; border-radius:999px; font-size:12px;
    }
  </style>
</head>
<body>

  <div class="card pay-card">
    <div class="pay-header d-flex align-items-center justify-content-between">
      <div class="brand">
        <div class="logo">L</div> LFCShop • Stripe
      </div>
      <span class="badge-test">Test Mode</span>
    </div>

    <div class="pay-body">
      @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
      @endif

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="fw-semibold">Payment Details</div>
        <div class="total-chip">
          <span>Total</span>
          <span>${{ $value }}</span>
        </div>
      </div>

      <form id="payment-form" action="{{ route('stripe.post', $value) }}" method="POST" novalidate>
        @csrf
        <div class="mb-3">
          <label class="form-label fw-semibold">Name on Card</label>
          <input id="card-holder-name" name="card-holder-name" type="text" class="form-control form-control-lg" placeholder="e.g. Touch Phanith" required>
        </div>

        <div class="mb-2">
          <label class="form-label fw-semibold">Credit / Debit Card</label>
          <div id="card-element" class="StripeElement"></div>
          <div id="card-errors" class="mt-2 text-danger small"></div>
          <div class="hint mt-2">Test card: <code>4242 4242 4242 4242</code> — any future date, any CVC/ZIP.</div>
        </div>

        <button id="card-button" class="btn btn-primary w-100 btn-pay mt-3" type="submit">
          <span class="spinner-border spinner-border-sm d-none" id="btn-spinner" role="status" aria-hidden="true"></span>
          <span id="btn-text">Pay ${{ $value }}</span>
        </button>

        <div class="text-center mt-3">
          <a href="{{ url('mycart') }}" class="text-decoration-none">← Back to Cart</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const stripe = Stripe("{{ config('stripe.key') }}");
    const elements = stripe.elements();

    const cardElement = elements.create('card', {
      hidePostalCode: true,
      style: {
        base: {
          iconColor: '#0d6efd',
          color: '#111827',
          fontFamily: '"Poppins", system-ui, sans-serif',
          fontSize: '16px',
          '::placeholder': { color: '#9ca3af' },
        },
        invalid: { color: '#dc3545' }
      }
    });
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    const btn  = document.getElementById('card-button');
    const btnSpinner = document.getElementById('btn-spinner');
    const btnText = document.getElementById('btn-text');

    function setLoading(state){
      if(state){
        btn.setAttribute('disabled', 'disabled');
        btnSpinner.classList.remove('d-none');
        btnText.textContent = 'Processing...';
      }else{
        btn.removeAttribute('disabled');
        btnSpinner.classList.add('d-none');
        btnText.textContent = 'Pay ${{ $value }}';
      }
    }

    // inline validation
    cardElement.on('change', function(e){
      document.getElementById('card-errors').textContent = e.error ? e.error.message : '';
    });

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      setLoading(true);

      const {token, error} = await stripe.createToken(cardElement);
      if (error) {
        document.getElementById('card-errors').textContent = error.message;
        setLoading(false);
        return;
      }

      // append token then submit
      const hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = 'stripeToken';
      hiddenInput.value = token.id;
      form.appendChild(hiddenInput);
      form.submit();
    });
  </script>
</body>
</html>
