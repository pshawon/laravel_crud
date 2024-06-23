<?php

namespace Database\Factories;
use App\Models\Profiles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profiles>
 */
class ProfilesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Profiles::class;
    public function definition(): array
    {

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => bcrypt('12'),
            'address' => $this->faker->address,
            'phone' => $this->generatePhoneNumber(),
            'image' => 'profiles ('.rand(1,13).').jpg',
            'attached' => 'attached ('.rand(1,14).').pdf',
            
        ];
        
    }
    private function generatePhoneNumber()
    {
        // Start with '01'
        $phoneNumber = '01';

        // Generate 9 random digits and append to '01'
        for ($i = 0; $i < 9; $i++) {
            $phoneNumber .= mt_rand(0, 9);
        }

        return $phoneNumber;
    }
}
