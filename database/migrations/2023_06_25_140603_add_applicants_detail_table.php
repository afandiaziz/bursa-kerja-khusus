<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->longText('cv')->nullable()->after('verified');
        });
        DB::statement('CREATE TABLE applicant_details LIKE user_details;');
        Schema::table('applicant_details', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Applicant::class)->after('id')->constrained('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn('cv');
        });
        Schema::dropIfExists('applicant_details');
    }
};
