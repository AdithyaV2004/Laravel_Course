<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    // Public: browse all courses
    public function index(Request $r)
    {
        $courses = Course::with('teacher')->withCount('students')
            ->when($r->q, fn ($q) => $q->where('title', 'like', "%{$r->q}%"))
            ->latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load(['teacher', 'comments.user', 'comments.replies.user'])->loadCount('students');
        $hasAccess = $course->hasAccess(auth()->user());
        return view('courses.show', compact('course', 'hasAccess'));
    }

    // ---- Teacher ----
    public function dashboard()
    {
        abort_unless(auth()->user()->isTeacher(), 403);
        $courses = auth()->user()->createdCourses()->with('students')->latest()->get();
        return view('courses.teacher', compact('courses'));
    }

    public function create()
    {
        abort_unless(auth()->user()->isTeacher(), 403);
        return view('courses.create');
    }

    public function store(Request $r)
    {
        abort_unless(auth()->user()->isTeacher(), 403);
        $data = $r->validate([
            'title' => 'required|max:150',
            'description' => 'required',
            'price' => 'required|numeric|min:0|max:99999',
            'file' => 'nullable|file|max:51200', // 50 MB (also check php.ini limits)
        ]);
        $path = $name = null;
        if ($r->hasFile('file')) {
            $name = $r->file('file')->getClientOriginalName();
            $path = $r->file('file')->store('course_files'); // private storage
        }
        $course = auth()->user()->createdCourses()->create([
            'title' => $data['title'], 'description' => $data['description'],
            'price' => $data['price'], 'file_path' => $path, 'file_name' => $name,
        ]);
        return redirect()->route('courses.show', $course)->with('ok', 'Course published!');
    }

    // ---- Student ----
    public function mine()
    {
        abort_unless(auth()->user()->isStudent(), 403);
        $courses = auth()->user()->purchasedCourses()->with('teacher')->latest('purchases.created_at')->get();
        return view('courses.mine', compact('courses'));
    }

    public function buy(Course $course)
    {
        abort_unless(auth()->user()->isStudent(), 403, 'Only students can buy courses.');
        // Demo "payment": integrate Stripe/Razorpay here later.
        auth()->user()->purchasedCourses()->syncWithoutDetaching([
            $course->id => ['price_paid' => $course->price],
        ]);
        return redirect()->route('courses.show', $course)->with('ok', 'Purchase successful!');
    }

    public function download(Course $course)
    {
        abort_unless($course->hasAccess(auth()->user()) && $course->file_path, 403);
        return Storage::download($course->file_path, $course->file_name);
    }
}
