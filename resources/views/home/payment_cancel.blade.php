@extends('home.layout')
@section('content')
<div class="container py-5">
  <h2>Payment Canceled</h2>
  <p>Your payment was canceled. You can try again anytime.</p>
  <a class="btn btn-secondary" href="{{ url('/cart') }}">Back to cart</a>
</div>
@endsection
