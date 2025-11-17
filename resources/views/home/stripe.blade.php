<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Stripe Payment | LFCShop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://js.stripe.com/v3/"></script>
  <style>
    body{min-height:100vh;background:linear-gradient(160deg,#0F6B63,#4FA7A5,#70B2B2,#A2D3D6);
         background-attachment:fixed;display:flex;align-items:center;justify-content:center;padding:24px;
         font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial}
    .card-wrap{max-width:560px;width:100%;border-radius:22px;overflow:hidden;box-shadow:0 18px 50px rgba(0,0,0,.25)}
    .hdr{background:rgba(255,255,255,.08);color:#fff;padding:20px 24px;font-weight:700;display:flex;justify-content:space-between}
    .body{background:#fff;padding:24px}
    .StripeElement{height:48px;padding:12px;border:1px solid #e5e7eb;border-radius:10px;background:#fafafa}
    .StripeElement--focus{background:#fff;border-color:#b6c8ff;box-shadow:0 0 0 4px rgba(13,110,253,.08)}
    .btn-pay{height:48px;border-radius:12px;font-weight:700}
    .hint{font-size:12px;color:#6b7280}
  </style>
</head>
<body>
  <div class="card-wrap">
    <div class="hdr">
      <div>LFCShop • Stripe</div>
      <span class="badge text-bg-light">Test Mode</span>
    </div>

    <div class="body">
      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

      <div class="d-flex justify-content-between mb-2">
        <div class="fw-semibold">Payment Details</div>
        <div class="badge rounded-pill text-bg-primary">Total ${{ $value }}</div>
      </div>

      <form id="payment-form" action="{{ route('stripe.post', $value) }}" method="post" novalidate>
        @csrf
        <div class="mb-3">
          <label class="form-label fw-semibold">Name on Card</label>
          <input id="card-holder-name" name="card-holder-name" class="form-control form-control-lg" placeholder="Touch Phanith">
        </div>

        <div class="mb-2">
          <label class="form-label fw-semibold">Credit / Debit Card</label>
          <div id="card-element" class="StripeElement"></div>
          <div id="card-errors" class="small text-danger mt-2"></div>
          <div class="hint mt-2">Test card: <code>4242 4242 4242 4242</code>, any future date, any CVC/ZIP.</div>
        </div>

        <button id="payBtn" class="btn btn-primary w-100 btn-pay mt-3" type="submit">
          Pay ${{ $value }}
        </button>

        <div class="text-center mt-3">
          <a href="{{ url('mycart') }}" class="text-decoration-none">← Back to Cart</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    const stripe = Stripe("{{ config('stripe.key') }}"); // STRIPE_KEY
    const elements = stripe.elements();
    const cardElement = elements.create('card', { hidePostalCode: true });
    cardElement.mount('#card-element');

    cardElement.on('change', (e) => {
      document.getElementById('card-errors').textContent = e.error ? e.error.message : '';
    });

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const {token, error} = await stripe.createToken(cardElement);
      if (error) {
        document.getElementById('card-errors').textContent = error.message;
        return;
      }
      const hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = 'stripeToken';
      hidden.value = token.id;
      form.appendChild(hidden);
      form.submit();
    });
  </script>
</body>
</html>
