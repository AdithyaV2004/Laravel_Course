@extends('layouts.app')
@section('content')
<h1>My Learning</h1>
<div class="grid">
@forelse($courses as $c)
  <div class="card">
    <h3><a href="{{ route('courses.show', $c) }}">{{ $c->title }}</a></h3>
    <p class="muted">By {{ $c->teacher->name }} · Paid ₹{{ number_format($c->pivot->price_paid, 2) }}</p>
    <a class="btn" href="{{ route('courses.show', $c) }}">Open</a>
  </div>
@empty
  <p>You haven't bought any courses yet. <a href="{{ route('home') }}">Browse</a>.</p>
@endforelse
</div>
@endsection
