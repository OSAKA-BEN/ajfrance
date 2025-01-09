<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        // Vérifions d'abord si les colonnes existent
        if (Schema::hasColumn('lessons', 'date')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->dropColumn('date');
            });
        }

        // Ajoutons les colonnes si elles n'existent pas
        if (!Schema::hasColumn('lessons', 'start_datetime')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->dateTime('start_datetime');
            });
        }

        if (!Schema::hasColumn('lessons', 'end_datetime')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->dateTime('end_datetime');
            });
        }

        if (!Schema::hasColumn('lessons', 'lesson_type')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->enum('lesson_type', ['skype', 'private'])->default('skype');
            });
        }
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->date('date')->nullable();
            
            if (Schema::hasColumn('lessons', 'start_datetime')) {
                // Copier les données de start_datetime vers date
                DB::table('lessons')->update([
                    'date' => DB::raw('DATE(start_datetime)')
                ]);

                $table->dropColumn('start_datetime');
            }

            if (Schema::hasColumn('lessons', 'end_datetime')) {
                $table->dropColumn('end_datetime');
            }

            if (Schema::hasColumn('lessons', 'lesson_type')) {
                $table->dropColumn('lesson_type');
            }

            $table->date('date')->nullable(false)->change();
        });
    }
}; 