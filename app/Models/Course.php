<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['teacher_id', 'title', 'description', 'price', 'file_path', 'file_name'];

    public function teacher() { return $this->belongsTo(User::class, 'teacher_id'); }

    public function students()
    {
        return $this->belongsToMany(User::class, 'purchases')->withPivot('price_paid')->withTimestamps();
    }

    public function comments() { return $this->hasMany(Comment::class)->whereNull('parent_id'); }

    // Owner teacher or a student who bought it
    public function hasAccess(?User $user): bool
    {
        if (!$user) return false;
        return $user->id === $this->teacher_id || $this->students()->where('users.id', $user->id)->exists();
    }
}
