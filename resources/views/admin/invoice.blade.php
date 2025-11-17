<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $data->id ?? '' }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        img {
            page-break-inside: avoid;
            max-height: 300px;
            /* កាត់រូបឲ្យសម A4 */
        }

        div,
        table,
        p,
        h1,
        h2,
        h3 {
            page-break-inside: avoid;
        }

        .invoice-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 30px;
            max-width: 650px;
            margin: 0 auto;
            border: 1px solid #e5e7eb;

            /* NEW: កាត់ margin/padding ដើម្បីមិនបែកទំព័រ */
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
            color: #1e40af;
            letter-spacing: 1px;
        }

        .info-section h3 {
            font-size: 16px;
            margin: 6px 0;
            color: #111827;
        }

        .info-section strong {
            color: #1e40af;
        }

        .product-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #9ca3af;
        }

        .product-section h2 {
            font-size: 18px;
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        .product-section p {
            font-size: 16px;
            margin: 5px 0;
            color: #111827;
        }

        .product-section img {
            margin-top: 15px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            width: 280px;
            height: auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .summary {
            margin-top: 30px;
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            padding: 8px 0;
            font-size: 15px;
        }

        .summary td:first-child {
            color: #6b7280;
        }

        .summary td:last-child {
            text-align: right;
            color: #111827;
        }

        .summary .total td:last-child {
            font-weight: 700;
            color: #1e40af;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #6b7280;
        }

        .footer span {
            color: #2563eb;
        }
    </style>
</head>

<body>

    <div class="invoice-container">

        <!-- Header -->
        <div class="header">
            <h1>LFC Order Invoice</h1>
        </div>

        <!-- Customer Info -->
        <div class="info-section">
            <h3><strong>Customer name:</strong> {{ $data->name ?? 'N/A' }}</h3>
            <h3><strong>Customer address:</strong> {{ $data->rec_address ?? 'N/A' }}</h3>
            <h3><strong>Phone:</strong> {{ $data->phone ?? 'N/A' }}</h3>
        </div>

        <!-- Product Info -->
        <div class="product-section">
            @if($data->product)
            <h2>Product title: {{ $data->product->title }}</h2>
            <p><strong>Price:</strong> ${{ number_format($data->product->price, 2) }}</p>

            <img
                src="{{ public_path('products/' . $data->product->image) }}"
                alt="Product Image"
                style="width:280px; height:auto; border-radius:8px; border:1px solid #d1d5db; margin-top:15px;">

            @else
            <h2 style="color: #ef4444;">⚠️ Product information not found</h2>
            @endif
        </div>

        <!-- Summary Section -->
        <div class="summary">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>${{ number_format($data->product->price ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>-${{ number_format($data->discount ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax (10%)</td>
                    <td>${{ number_format(($data->product->price ?? 0) * 0.10, 2) }}</td>
                </tr>
                <tr class="total">
                    <td>Total</td>
                    <td>
                        ${{ number_format(($data->product->price ?? 0) - ($data->discount ?? 0) + (($data->product->price ?? 0) * 0.10), 2) }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with <span>LFC Store</span> ❤️</p>
            <p>Generated on: {{ \Carbon\Carbon::now('Asia/Phnom_Penh')->format('d M Y, h:i A') }}</p>
        </div>

    </div>

</body>

</html>