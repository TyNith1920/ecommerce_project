<script>
  const btn = document.getElementById('btnPayABA');
  const modal = document.getElementById('abaModal');
  const qrImg = document.getElementById('qrImg');
  const closeBtn = document.getElementById('closeAba');

  function openModal(){ modal.style.display='flex'; }
  function closeModal(){ modal.style.display='none'; }
  if (closeBtn) closeBtn.onclick = closeModal;

  btn.onclick = async () => {
    try {
      const payload = {
        amount: {{ $amount }},
        currency: 'USD',
        product_id: {{ $product->id }}
      };

      const res = await fetch('{{ route("payway.purchase") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
      });

      const json = await res.json();
      if (!json.ok) { alert('Payment init failed: ' + (json.message || 'unknown')); return; }

      const g = json.gateway || {};
      if (g.qrImage) {
        qrImg.src = g.qrImage; openModal();
      } else if (g.qrString) {
        qrImg.src = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='
                    + encodeURIComponent(g.qrString);
        openModal();
      } else if (g.payment_url) {
        window.location = g.payment_url;
      } else {
        alert('No QR or URL returned from gateway.');
      }
    } catch (e) {
      alert('Error: ' + e.message);
    }
  };
</script>
