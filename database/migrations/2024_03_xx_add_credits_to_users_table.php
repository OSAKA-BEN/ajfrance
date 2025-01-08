<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('credits')->default(0);
        });

        // Attribuer 2 crédits aux utilisateurs guest existants
        DB::table('users')->where('role', 'guest')->update(['credits' => 2]);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('credits');
        });
    }
}; 