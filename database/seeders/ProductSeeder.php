<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Product();
        $product->name = "Product 1";
        $product->category_id = 1;
        $product->company_id = 1;
        $product->sub_category_id = 1;
        $product->created_by = 1;
        $product->save();

        $productCode = "#P0001";

        $ProductAttribute = new ProductAttribute();
        $ProductAttribute->product_id = $product->id;
        $ProductAttribute->company_id = $product->category_id;
        $ProductAttribute->code = $productCode;
        $ProductAttribute->size = "LG";
        $ProductAttribute->color = "Red";
        $ProductAttribute->current_stock = 10;
        $ProductAttribute->last_purchase = 20;
        $ProductAttribute->model = "None";
        $ProductAttribute->unit_cost = 20.00;
        $ProductAttribute->sales_rate = 23.10;
        $ProductAttribute->save();

    }
}
