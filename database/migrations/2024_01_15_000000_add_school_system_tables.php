<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Modifier la table users existante
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('password');
            $table->text('about')->nullable()->after('phone');
            $table->string('address')->nullable()->after('about');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('zipcode')->nullable()->after('state');
            $table->string('country')->nullable()->after('zipcode');
            $table->string('profile_image')->nullable()->after('country');
            $table->enum('role', ['admin', 'teacher', 'student', 'guest'])->after('profile_image');
            $table->integer('credits')->default(0)->after('role');
        });

        // Table School Schedules
        Schema::create('school_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('day_of_week');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });

        // Table School Closures
        Schema::create('school_closures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['holiday', 'vacation', 'special_event']);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Table Teacher Availabilities
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        // Table Teacher Absences
        Schema::create('teacher_absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['vacation', 'sick_leave', 'other']);
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        // Table Lessons
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->enum('lesson_type', ['skype', 'private']);
            $table->enum('status', ['reserved', 'completed', 'cancelled'])->default('reserved');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('teacher_absences');
        Schema::dropIfExists('availabilities');
        Schema::dropIfExists('school_closures');
        Schema::dropIfExists('school_schedules');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'about',
                'address',
                'city',
                'state',
                'zipcode',
                'country',
                'profile_image',
                'role',
                'credits'
            ]);
        });
    }
}; 