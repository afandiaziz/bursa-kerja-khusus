<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('criteria_type_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('criteria_id');
            $table->string('answer');
            $table->boolean('extra_answer_type')->nullable();
            $table->foreign('criteria_id')->references('id')->on('criteria');
            $table->index('criteria_id');
            $table->index('answer');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_type_answers');
    }
};
