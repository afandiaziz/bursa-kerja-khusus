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
        Schema::create('vacancy_criteria', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(\App\Models\Vacancy::class);
            $table->foreignIdFor(\App\Models\Criteria::class);

            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');
            $table->index('vacancy_id');
            $table->foreign('criteria_id')->references('id')->on('criteria')->onDelete('cascade');
            $table->index('criteria_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancy_criteria');
    }
};
