<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $r, Course $course)
    {
        abort_unless($course->hasAccess($r->user()), 403, 'Buy this course to join the forum.');
        $data = $r->validate(['body' => 'required|max:2000', 'parent_id' => 'nullable|integer']);

        $parentId = null;
        if (!empty($data['parent_id'])) {
            $parent = Comment::where('course_id', $course->id)->findOrFail($data['parent_id']);
            $parentId = $parent->parent_id ?? $parent->id; // keep replies one level deep
        }
        $course->comments()->getQuery()->getModel()->create([
            'course_id' => $course->id, 'user_id' => $r->user()->id,
            'parent_id' => $parentId, 'body' => $data['body'],
        ]);
        return back();
    }
}
