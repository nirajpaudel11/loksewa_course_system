<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->float('learning_pace_multiplier')->default(1.0);
        });

        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->float('easiness_factor')->default(2.5); // SM-2 parameter
            $table->integer('interval')->default(0);        // SM-2 parameter
            $table->integer('repetitions')->default(0);     // SM-2 parameter
            $table->timestamp('next_review_date')->nullable();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->float('trending_score')->default(0.0);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('learning_pace_multiplier');
        });

        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->dropColumn(['easiness_factor', 'interval', 'repetitions', 'next_review_date']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('trending_score');
        });
    }
};
