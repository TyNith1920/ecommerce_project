@extends('admin.body')

@section('title', 'Manage Orders')

@section('content')
<div class="container-fluid py-4">

  <!-- Main Card -->
  <div class="card shadow-lg border-0" style="background: var(--card-bg);">
    <div class="card-body">

      <!-- 🧭 Header Title -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="text-gradient mb-0">All Orders</h2>

        <!-- 🔍 Search & Filter -->
        <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex flex-wrap gap-2">
          <input type="text" name="search" class="form-control form-control-sm"
                 placeholder="Search by customer or product..."
                 value="{{ request('search') }}" style="min-width: 220px;">

          <select name="status" class="form-select form-select-sm" style="min-width: 180px;">
            <option value="">All Status</option>
            <option value="in progress" {{ request('status') == 'in progress' ? 'selected' : '' }}>In Progress</option>
            <option value="On the way" {{ request('status') == 'On the way' ? 'selected' : '' }}>On the Way</option>
            <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
          </select>

          <button type="submit" class="btn btn-primary btn-sm px-3">
            <i class="fa fa-search"></i> Filter
          </button>

          @if(request('search') || request('status'))
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm px-3">
              <i class="fa fa-rotate-left"></i> Reset
            </a>
          @endif
        </form>
      </div>

      <!-- 🧾 Orders Table -->
      <div class="table-responsive">
        <table class="table table-dark table-hover text-center align-middle rounded">
          <thead class="table-primary">
            <tr>
              <th>Customer Name</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Product Title</th>
              <th>Price</th>
              <th>Image</th>
              <th>Payment Status</th>
              <th>Status</th>
              <th>Change Status</th>
              <th>Print PDF</th>
            </tr>
          </thead>

          <tbody>
            @forelse($data as $item)
              <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->rec_address }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->product ? $item->product->title : 'N/A' }}</td>
                <td>{{ $item->product ? '$' . $item->product->price : 'N/A' }}</td>
                <td>
                  @if($item->product && $item->product->image)
                    <img src="{{ asset('products/' . $item->product->image) }}" width="70" height="70" class="rounded shadow-sm">
                  @else
                    <span class="text-muted">No Image</span>
                  @endif
                </td>
                <td>{{ $item->payment_status }}</td>

                <td>
                  @if($item->status == 'in progress')
                    <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                  @elseif($item->status == 'On the way')
                    <span class="badge bg-info text-dark">{{ $item->status }}</span>
                  @elseif($item->status == 'Delivered')
                    <span class="badge bg-success">{{ $item->status }}</span>
                  @else
                    <span class="badge bg-secondary">{{ $item->status }}</span>
                  @endif
                </td>

                <td>
                  @if($item->status == 'in progress')
                    <a href="{{ url('admin/orders/on-the-way/'.$item->id) }}" class="btn btn-sm btn-primary">On the way</a>
                  @elseif($item->status == 'On the way')
                    <a href="{{ url('admin/orders/delivered/'.$item->id) }}" class="btn btn-sm btn-success">Delivered</a>
                  @else
                    <button class="btn btn-sm btn-secondary" disabled>Completed</button>
                  @endif
                </td>

                <td>
                  <a href="{{ url('admin/orders/print/'.$item->id) }}" class="btn btn-sm btn-danger">Print PDF</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center text-muted py-3">
                  <i class="fa fa-box-open"></i> No orders found
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>

</div>
@endsection
