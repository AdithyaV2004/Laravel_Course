<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $t) {
            $t->id();
            $t->foreignId('teacher_id')->constrained('users')->cascadeOnDelete(); // who made it
            $t->string('title');
            $t->text('description');
            $t->decimal('price', 8, 2)->default(0);
            $t->string('file_path')->nullable();
            $t->string('file_name')->nullable();
            $t->timestamps();
        });

        // which students bought which course
        Schema::create('purchases', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('course_id')->constrained()->cascadeOnDelete();
            $t->decimal('price_paid', 8, 2);
            $t->timestamps();
            $t->unique(['user_id', 'course_id']);
        });

        // forum: parent_id null = top-level comment, otherwise a reply
        Schema::create('comments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('course_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $t->text('body');
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('courses');
    }
};
