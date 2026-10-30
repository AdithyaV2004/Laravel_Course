@extends('layouts.app')
@section('content')
<h1>My Courses</h1>
@forelse($courses as $c)
<div class="card" style="margin-bottom:12px">
  <h3><a href="{{ route('courses.show', $c) }}">{{ $c->title }}</a> <span class="price">₹{{ number_format($c->price, 2) }}</span></h3>
  <p class="muted">{{ $c->students->count() }} students · Earned ₹{{ number_format($c->students->sum('pivot.price_paid'), 2) }}</p>
  @if($c->students->count())
  <table><tr><th>Student</th><th>Email</th><th>Bought</th></tr>
    @foreach($c->students as $s)
    <tr><td>{{ $s->name }}</td><td>{{ $s->email }}</td><td>{{ $s->pivot->created_at->format('d M Y') }}</td></tr>
    @endforeach
  </table>
  @endif
</div>
@empty
  <p>You haven't created any courses. <a href="{{ route('courses.create') }}">Create one</a>.</p>
@endforelse
@endsection
