<?php

use Illuminate\Database\Seeder;
use App\Models\ProductModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ProductsTableSeeder::class);
    }
}

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductModel::create([
            'product_name' => 'Moto M',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'Android Phones',
            'attributes' => '{"color":"Gold","OS":"Android Nougat"}',
            'price' => '15599',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
        ProductModel::create([
            'product_name' => 'Moto E',
            'product_category' => 'Smartphones',
            'product_sub_category' => 'Android Phones',
            'attributes' => '{"color":"Black","OS":"Android Nougat"}',
            'price' => '7599',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1,
        ]);
    }
}
