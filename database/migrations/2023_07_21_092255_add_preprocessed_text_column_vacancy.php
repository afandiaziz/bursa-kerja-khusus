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
        Schema::table('vacancies', function (Blueprint $table) {
            $table->text('preprocessed_text_id')->after('description')->nullable();
            $table->text('preprocessed_text_id_eng')->after('preprocessed_text_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn('preprocessed_text_id');
            $table->dropColumn('preprocessed_text_id_eng');
        });
    }
};
