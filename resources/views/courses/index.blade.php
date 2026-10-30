@extends('layouts.app')
@section('content')
<h1>All Courses</h1>
<form method="GET"><input name="q" value="{{ request('q') }}" placeholder="Search courses..."></form>
<div class="grid">
@forelse($courses as $c)
  <div class="card">
    <h3><a href="{{ route('courses.show', $c) }}">{{ $c->title }}</a></h3>
    <p>{{ \Illuminate\Support\Str::limit($c->description, 100) }}</p>
    <p class="muted">By {{ $c->teacher->name }} · {{ $c->students_count }} students</p>
    <span class="price">{{ $c->price > 0 ? '₹'.number_format($c->price, 2) : 'Free' }}</span>
  </div>
@empty
  <p>No courses yet.</p>
@endforelse
</div>
@endsection
