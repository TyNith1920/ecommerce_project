<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ABA PayWay RSA Sandbox</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>.qr{max-width:320px;border-radius:12px;box-shadow:0 8px 26px rgba(0,0,0,.12)}</style>
</head>
<body class="p-4 text-center">
  <div class="container">
    <h2>PayWay RSA Demo</h2>
    <h4>Total: $2.00</h4>
    <button id="checkout" class="btn btn-primary mt-2">Pay with ABA</button>

    <div id="qrWrap" class="mt-4" style="display:none;">
      <img id="qrImg" class="qr" src="" alt="QR">
    </div>
    <pre id="resp" class="text-start bg-light p-2 mt-3 small"></pre>
  </div>

  <script>
  document.getElementById('checkout').onclick = async () => {
    const r = await fetch('purchase.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({amount:2.00, currency:'USD'})
    });
    const j = await r.json();
    document.getElementById('resp').textContent = JSON.stringify(j, null, 2);
    if (j.ok) {
      const g = j.data;
      const img = document.getElementById('qrImg');
      if (g.qrImage) img.src = g.qrImage;
      else if (g.qrString)
        img.src = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='
                  + encodeURIComponent(g.qrString);
      document.getElementById('qrWrap').style.display = 'block';
    } else {
      alert('Error: ' + j.error);
    }
  };
  </script>
</body>
</html>
