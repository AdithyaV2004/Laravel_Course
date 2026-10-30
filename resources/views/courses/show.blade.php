@extends('layouts.app')
@section('content')
<div class="card">
  <h1>{{ $course->title }}</h1>
  <p class="muted">By {{ $course->teacher->name }} · {{ $course->students_count }} students enrolled</p>
  <p style="white-space:pre-line">{{ $course->description }}</p>
  <p class="price">{{ $course->price > 0 ? '₹'.number_format($course->price, 2) : 'Free' }}</p>

  @if($hasAccess)
    @if($course->file_path)
      <a class="btn" href="{{ route('courses.download', $course) }}">⬇ Download: {{ $course->file_name }}</a>
    @else <p class="muted">No file uploaded.</p> @endif
  @elseif(auth()->check() && auth()->user()->isStudent())
    <form method="POST" action="{{ route('courses.buy', $course) }}">@csrf
      <button class="btn">Buy for ₹{{ number_format($course->price, 2) }}</button>
    </form>
  @elseif(!auth()->check())
    <a class="btn" href="{{ route('login') }}">Login to buy</a>
  @endif
</div>

<h2>💬 Course Forum</h2>
@if($hasAccess)
<div class="card">
  <form method="POST" action="{{ route('comments.store', $course) }}">@csrf
    <textarea name="body" rows="3" placeholder="Ask a question or share something..." required></textarea>
    <button class="btn">Post</button>
  </form>
</div>
@else
  <p class="muted">Buy this course to join the discussion.</p>
@endif

@foreach($course->comments->sortByDesc('created_at') as $comment)
<div class="card" style="margin-top:12px">
  <strong>{{ $comment->user->name }}</strong>
  @if($comment->user_id === $course->teacher_id)<span class="badge">Teacher</span>@endif
  <span class="muted">{{ $comment->created_at->diffForHumans() }}</span>
  <p style="white-space:pre-line">{{ $comment->body }}</p>

  @foreach($comment->replies as $reply)
    <div class="reply">
      <strong>{{ $reply->user->name }}</strong>
      @if($reply->user_id === $course->teacher_id)<span class="badge">Teacher</span>@endif
      <span class="muted">{{ $reply->created_at->diffForHumans() }}</span>
      <p style="white-space:pre-line">{{ $reply->body }}</p>
    </div>
  @endforeach

  @if($hasAccess)
  <form method="POST" action="{{ route('comments.store', $course) }}" class="reply">@csrf
    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
    <input name="body" placeholder="Write a reply..." required>
    <button class="btn" style="padding:4px 12px">Reply</button>
  </form>
  @endif
</div>
@endforeach
@endsection
