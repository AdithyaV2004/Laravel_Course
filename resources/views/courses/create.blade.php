@extends('layouts.app')
@section('content')
<div class="card">
  <h2>Upload a new course</h2>
  <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">@csrf
    <label>Title</label><input name="title" value="{{ old('title') }}" required>
    <label>Description</label><textarea name="description" rows="5" required>{{ old('description') }}</textarea>
    <label>Price (₹) — 0 for free</label><input type="number" step="0.01" min="0" name="price" value="{{ old('price', 0) }}" required>
    <label>Course file (video / PDF / ZIP, max 50 MB)</label><input type="file" name="file">
    @foreach($errors->all() as $e)<div class="err">{{ $e }}</div>@endforeach
    <button class="btn">Publish</button>
  </form>
</div>
@endsection
