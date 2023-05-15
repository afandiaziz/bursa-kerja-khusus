<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\Vacancy;
use App\Models\VacancyCriteria;
use Illuminate\Database\Seeder;

class VacancyCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        VacancyCriteria::truncate();
        Vacancy::get()->each(function ($vacancy) {
            $random = fake()->numberBetween(4, 10);
            $selectedId = [];
            for ($i = 0; $i < $random; $i++) {
                $criteriaId = Criteria::whereNotIn('id', $selectedId)->inRandomOrder()->first()->id;
                if (!in_array($criteriaId, $selectedId)) {
                    array_push($selectedId, $criteriaId);
                    VacancyCriteria::create([
                        'vacancy_id' => $vacancy->id,
                        'criteria_id' => $criteriaId,
                    ]);
                }
            }
        });
    }
}
