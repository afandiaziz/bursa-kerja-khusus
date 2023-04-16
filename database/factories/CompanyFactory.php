<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('id_ID')->company(),
            'logo' => fake('id_ID')->imageUrl(),
            'website' => fake('id_ID')->word() . fake('id_ID')->word() . '.site',
            'email' => fake('id_ID')->unique()->companyEmail(),
            'phone' => fake('id_ID')->phoneNumber(),
            'address' => fake('id_ID')->address(),
        ];
    }
}
