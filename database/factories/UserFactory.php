<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->userName() . '@test.com',
            'email_verified_at' => null,
            'password' => Hash::make('password123'),
            'remember_token' => null,
            'about' => $this->faker->sentence,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->randomElement(['Hokkaido', 'Aomori', 'Iwate', 'Miyagi', 'Akita', 'Yamagata', 'Fukushima', 'Ibaraki', 'Tochigi', 'Gunma', 'Saitama', 'Chiba', 'Tokyo', 'Kanagawa', 'Niigata', 'Toyama', 'Ishikawa', 'Fukui', 'Yamanashi', 'Nagano', 'Gifu', 'Shizuoka', 'Aichi', 'Mie', 'Shiga', 'Kyoto', 'Osaka', 'Hyogo', 'Nara', 'Wakayama', 'Tottori', 'Shimane', 'Okayama', 'Hiroshima', 'Yamaguchi', 'Tokushima', 'Kagawa', 'Ehime', 'Kochi', 'Fukuoka', 'Saga', 'Nagasaki', 'Kumamoto', 'Oita', 'Miyazaki', 'Kagoshima', 'Okinawa']),
            'zipcode' => $this->faker->postcode,
            'country' => 'Japan',
            'phone' => $this->faker->phoneNumber,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
                'credits' => 0,
            ];
        });
    }

    public function teacher()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'teacher',
                'credits' => 0,
            ];
        });
    }

    public function student()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'student',
                'credits' => 2,
            ];
        });
    }

    public function guest()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'guest',
                'credits' => 2,
            ];
        });
    }
}
