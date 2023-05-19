<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Applicant::truncate();
        Applicant::create([
            'vacancy_id' => Vacancy::first()->id,
            'user_id' => User::first()->id,
        ]);
        Applicant::create([
            'vacancy_id' => Vacancy::first()->id,
            'user_id' => User::first()->id,
        ]);
        Applicant::create([
            'vacancy_id' => Vacancy::first()->id,
            'user_id' => User::first()->id,
        ]);
    }
}
