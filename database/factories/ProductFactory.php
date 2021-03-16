<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'sku' => rand(000000, 999999),
            'company_id' => rand(1,2),
            'unit' => 'шт',
            'tax' => 20,
            'price' => rand(10000, 100000),
            'product_category_id' => 1
        ];
    }
}
