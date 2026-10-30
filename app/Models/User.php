<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function isTeacher(): bool { return $this->role === 'teacher'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    public function createdCourses() { return $this->hasMany(Course::class, 'teacher_id'); }

    public function purchasedCourses()
    {
        return $this->belongsToMany(Course::class, 'purchases')->withPivot('price_paid')->withTimestamps();
    }
}
