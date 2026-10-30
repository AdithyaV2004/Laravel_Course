<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title ?? 'CourseHub' }}</title>
<style>
  *{box-sizing:border-box} body{font-family:system-ui,sans-serif;margin:0;background:#f5f6fa;color:#222}
  nav{background:#1f2937;color:#fff;padding:12px 24px;display:flex;gap:16px;align-items:center;flex-wrap:wrap}
  nav a,nav button{color:#fff;text-decoration:none;background:none;border:0;font:inherit;cursor:pointer}
  nav .brand{font-weight:700;font-size:1.2rem;margin-right:auto}
  main{max-width:960px;margin:24px auto;padding:0 16px}
  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px}
  .card{background:#fff;border-radius:10px;padding:16px;box-shadow:0 1px 4px #0001}
  .price{font-weight:700;color:#059669}
  .btn{display:inline-block;background:#4f46e5;color:#fff;padding:8px 16px;border-radius:6px;border:0;cursor:pointer;text-decoration:none;font:inherit}
  input,textarea,select{width:100%;padding:8px;margin:4px 0 12px;border:1px solid #ccc;border-radius:6px;font:inherit}
  .err{color:#b91c1c;font-size:.9rem} .ok{background:#d1fae5;padding:10px;border-radius:6px;margin-bottom:12px}
  .muted{color:#6b7280;font-size:.85rem} .badge{background:#e0e7ff;color:#3730a3;border-radius:4px;padding:1px 6px;font-size:.75rem}
  .reply{margin-left:32px;border-left:3px solid #e5e7eb;padding-left:12px}
  table{width:100%;border-collapse:collapse} td,th{padding:8px;border-bottom:1px solid #eee;text-align:left}
</style>
</head>
<body>
<nav>
  <a class="brand" href="{{ route('home') }}">📚 CourseHub</a>
  <a href="{{ route('home') }}">Browse</a>
  @auth
    @if(auth()->user()->isTeacher())
      <a href="{{ route('teacher.dashboard') }}">My Courses</a>
      <a href="{{ route('courses.create') }}">+ New Course</a>
    @else
      <a href="{{ route('student.courses') }}">My Learning</a>
    @endif
    <span class="muted" style="color:#9ca3af">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
    <form method="POST" action="{{ route('logout') }}">@csrf<button>Logout</button></form>
  @else
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Register</a>
  @endauth
</nav>
<main>
  @if(session('ok'))<div class="ok">{{ session('ok') }}</div>@endif
  @yield('content')
</main>
</body>
</html>
