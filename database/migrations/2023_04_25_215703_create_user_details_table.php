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
        Schema::create('user_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Criteria::class);
            $table->longText('value')->nullable();
            $table->longText('extra_value')->nullable();

            $table->string('filename')->nullable();
            $table->string('path')->nullable();
            $table->string('mime_type')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->foreign('criteria_id')->references('id')->on('criteria')->onDelete('cascade');
            $table->index('criteria_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
