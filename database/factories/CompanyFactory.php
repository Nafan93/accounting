<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        
        $name = $this->faker->name ; 
        
        return [
            'name' => $name . ' company',
            'full_name' => $name . ' company full name',
            'director_post' => 'Директор',
            'director_name' => $name . ' director',
            'inn' => rand(111111,999999),
            'kpp' => rand(111111,999999),
            'legal_addres' => $name . ' legal addres'
        ];
    }
    
}
