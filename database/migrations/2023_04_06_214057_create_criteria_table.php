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
        Schema::create('criteria', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignIdFor(\App\Models\CriteriaType::class);
            $table->uuid('parent_id')->nullable();
            $table->integer('parent_order')->nullable();
            $table->integer('child_order')->nullable();
            $table->integer('max_length')->nullable();
            $table->integer('min_length')->nullable();
            $table->integer('max_number')->nullable();
            $table->integer('min_number')->nullable();
            $table->boolean('type_upload')->nullable()->default(null)->comment('true = multiple, false = single');
            $table->integer('max_size')->nullable()->comment('in MB');
            $table->integer('max_files')->nullable()->comment('items');
            $table->text('format_file')->nullable();
            $table->json('custom_label')->nullable();
            $table->string('mask')->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('active')->default(true);
            $table->index('id');
            $table->index('name');

            $table->foreign('criteria_type_id')->references('id')->on('criteria_types')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};
