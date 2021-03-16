<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rnd = rand(1,3);
        $rand = rand(1,10);
        $name = $this->faker->name ; 
        return [
            'company_id' => $rnd,
            'name' => 'My company ' . $rnd . ' customer ' . $rand,
            'full_name' => 'My company ' . $rnd . ' customer ' . $rand,
            'director_name' => $name . ' director',
            'director_post' => 'Директор',
            'inn' => rand(111111,999999),
            'kpp' => rand(111111,999999),
            'legal_addres' => $name . ' legal addres'
        ];
    }
}
