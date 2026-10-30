@extends('layouts.app')
@section('content')
<div class="card" style="max-width:400px;margin:auto">
  <h2>Create account</h2>
  <form method="POST" action="{{ route('register') }}">@csrf
    <label>Name</label><input name="name" value="{{ old('name') }}" required>
    <label>Email</label><input type="email" name="email" value="{{ old('email') }}" required>
    <label>Password</label><input type="password" name="password" required>
    <label>Confirm password</label><input type="password" name="password_confirmation" required>
    <label>I am a</label>
    <select name="role"><option value="student">Student</option><option value="teacher">Teacher</option></select>
    @foreach($errors->all() as $e)<div class="err">{{ $e }}</div>@endforeach
    <button class="btn">Register</button>
  </form>
</div>
@endsection
