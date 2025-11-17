<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F9FAFB; }
        .font-lexend { font-family: 'Lexend', sans-serif; }
    </style>
</head>
<body class="text-gray-800 flex items-center justify-center h-screen">
    <div class="text-center bg-white p-12 rounded-lg shadow-xl">
        <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h1 class="mt-4 text-3xl font-lexend font-bold text-gray-900">Thank You!</h1>
        <p class="mt-2 text-gray-600">Your payment was successful and your order is complete.</p>
        <a href="{{ route('shop') }}" class="mt-8 inline-block bg-gray-800 text-white px-8 py-3 rounded-lg hover:bg-gray-900 transition font-semibold">
            Continue Shopping
        </a>
    </div>
</body>
</html>
