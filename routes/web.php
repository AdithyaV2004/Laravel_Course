<?php
use App\Http\Controllers\{AuthController, CourseController, CommentController};
use Illuminate\Support\Facades\Route;

Route::get('/', [CourseController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // teacher
    Route::get('/teacher', [CourseController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');

    // student
    Route::get('/my-courses', [CourseController::class, 'mine'])->name('student.courses');
    Route::post('/courses/{course}/buy', [CourseController::class, 'buy'])->name('courses.buy');

    // shared
    Route::get('/courses/{course}/download', [CourseController::class, 'download'])->name('courses.download');
    Route::post('/courses/{course}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show')->whereNumber('course');
