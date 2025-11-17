@extends('home.layout')
@section('content')
<div class="container py-5">
  <h2>Payment Success</h2>
  <p>Thanks! We’ll process your order shortly.</p>
  <a class="btn btn-primary" href="{{ url('/') }}">Continue shopping</a>
</div>
@endsection
