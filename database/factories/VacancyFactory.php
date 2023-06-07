<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyId = Company::select('id')->inRandomOrder()->firstOrFail();
        $jobType = ['Full-time', 'Part-time', 'Internship', 'Contract', 'Temporary', 'Volunteer'];
        return [
            'company_id' => $companyId,
            'position' => fake('id_ID')->jobTitle(),
            'description' => fake('id_ID')->paragraph(),
            'information' => fake('id_ID')->sentence(),
            'job_type' => fake('id_ID')->randomElement($jobType),
            'deadline' => fake('id_ID')->dateTimeBetween('now', '+3 months', 'Asia/Jakarta'),
        ];
    }
}
