<?php

namespace Database\Factories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Request::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'priority' => rand(1,5),
            'number_to_be_rescued' => rand(1,5),
            'address' => $this->faker->address,
            'contact_number' => $this->faker->phoneNumber
        ];
    }
}
