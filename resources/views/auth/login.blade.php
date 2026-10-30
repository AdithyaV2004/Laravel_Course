@extends('layouts.app')
@section('content')
<div class="card" style="max-width:400px;margin:auto">
  <h2>Login</h2>
  <form method="POST" action="{{ route('login') }}">@csrf
    <label>Email</label><input type="email" name="email" value="{{ old('email') }}" required>
    @error('email')<div class="err">{{ $message }}</div>@enderror
    <label>Password</label><input type="password" name="password" required>
    <label><input type="checkbox" name="remember" style="width:auto"> Remember me</label><br><br>
    <button class="btn">Login</button>
  </form>
</div>
@endsection
