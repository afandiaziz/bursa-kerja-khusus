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
        Schema::create('cbrs_words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
        });
        Schema::create('cbrs_result', function (Blueprint $table) {
            $table->id();
            $table->integer('word_id');
            $table->integer('document_id');
            $table->string('tf');
            $table->string('tfidf')->nullable();
            $table->string('normalized_tfidf')->nullable();
        });
        Schema::create('cbrs_tfidf', function (Blueprint $table) {
            $table->id();
            $table->integer('word_id');
            $table->string('tf');
            $table->string('idf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbrs_words');
        Schema::dropIfExists('cbrs_result');
        Schema::dropIfExists('cbrs_tfidf');
    }
};
