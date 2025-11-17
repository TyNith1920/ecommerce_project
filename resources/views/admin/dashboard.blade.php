@extends('admin.body')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard Overview</h1>

    {{-- Cards --}}
    <div class="row g-4">
        <div class="col-md-3 col-sm-6">
            <div class="dashboard-card gradient-red text-center p-4 shadow-sm">
                <h5 class="text-light">TOTAL CLIENTS</h5>
                <h2 class="fw-bold text-white mt-2">{{ $totalClients }}</h2>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="dashboard-card gradient-green text-center p-4 shadow-sm">
                <h5 class="text-light">TOTAL PRODUCTS</h5>
                <h2 class="fw-bold text-white mt-2">{{ $totalProducts }}</h2>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="dashboard-card gradient-yellow text-center p-4 shadow-sm">
                <h5 class="text-light">TOTAL ORDERS</h5>
                <h2 class="fw-bold text-white mt-2">{{ $totalOrders }}</h2>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="dashboard-card gradient-blue text-center p-4 shadow-sm">
                <h5 class="text-light">TOTAL DELIVERED</h5>
                <h2 class="fw-bold text-white mt-2">{{ $totalDelivered }}</h2>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="dashboard-chart mt-5 p-4 rounded shadow-sm">
        <h4 class="mb-3 fw-semibold">Order Overview Chart</h4>
        <canvas id="ordersChart" height="120"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Clients','Products','Orders','Delivered'],
            datasets: [{
                label: 'Statistics',
                data: [{{ $totalClients }}, {{ $totalProducts }}, {{ $totalOrders }}, {{ $totalDelivered }}],
                backgroundColor: ['#ef4444','#22c55e','#eab308','#3b82f6'],
                borderRadius: 8
            }]
        },
        options: {
            plugins: {
                legend: { labels: { color: getComputedStyle(document.body).getPropertyValue('--text-color').trim() } }
            },
            scales: {
                x: { ticks: { color: getComputedStyle(document.body).getPropertyValue('--text-color').trim() } },
                y: { ticks: { color: getComputedStyle(document.body).getPropertyValue('--text-color').trim() } }
            }
        }
    });
</script>

<style>
/* 🌈 Gradient Card Style */
.dashboard-card {
    border-radius: 15px;
    color: white;
    transition: all 0.3s ease;
}
.dashboard-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

/* 🟥 Red gradient */
.gradient-red {
    background: linear-gradient(135deg, #ef4444, #b91c1c);
}

/* 🟩 Green gradient */
.gradient-green {
    background: linear-gradient(135deg, #22c55e, #15803d);
}

/* 🟨 Yellow gradient */
.gradient-yellow {
    background: linear-gradient(135deg, #eab308, #a16207);
}

/* 🟦 Blue gradient */
.gradient-blue {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
}

/* 📊 Chart Section */
.dashboard-chart {
    background-color: var(--card-bg);
    border-radius: 15px;
    transition: background-color 0.3s ease;
}

/* ✨ Small adjustments */
.text-light {
    color: #f3f4f6 !important;
}
</style>
@endsection
