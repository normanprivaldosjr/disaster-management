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
        $fakerPH = \Faker\Factory::create('en_PH');

        return [
            'name' => $fakerPH->name,
            'number_to_be_rescued' => rand(1,5),
            'address' => $fakerPH->address,
            'contact_number' => $fakerPH->mobileNumber
        ];
    }
}
