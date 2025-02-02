<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $product->sub_category_id = 2;
        $product->created_by = 1;
        $product->save();

        $productCode = "#P0001";

        $ProductAttribute = new ProductAttribute();
        $ProductAttribute->product_id = $product->id;
        $ProductAttribute->company_id = $product->category_id;
        $ProductAttribute->code = $productCode;
        $ProductAttribute->size = "LG";
        $ProductAttribute->color = "Red";
        $ProductAttribute->current_stock = 500;
        $ProductAttribute->last_purchase = 20;
        $ProductAttribute->model = "None";
        $ProductAttribute->unit_cost = 20.00;
        $ProductAttribute->sales_rate = 23.10;
        $ProductAttribute->save();





        $productCode = "#P0002";

        $ProductAttribute = new ProductAttribute();
        $ProductAttribute->product_id = $product->id;
        $ProductAttribute->company_id = $product->category_id;
        $ProductAttribute->code = $productCode;
        $ProductAttribute->size = "XL";
        $ProductAttribute->color = "Back";
        $ProductAttribute->current_stock = 100;
        $ProductAttribute->last_purchase = 60;
        $ProductAttribute->model = "None";
        $ProductAttribute->unit_cost = 80.00;
        $ProductAttribute->sales_rate = 90;
        $ProductAttribute->save();




        // for ($i = 0; $i < 100; $i++) {


        //     $ProductAttribute = new ProductAttribute();
        //     $ProductAttribute->product_id = $product->id;
        //     $ProductAttribute->company_id = $product->category_id;
        //     $ProductAttribute->code = "#P000" . $i;
        //     $ProductAttribute->size = Str::random(2) . $i;
        //     $ProductAttribute->color = Str::random(4);
        //     $ProductAttribute->current_stock = random_int(2, 100);
        //     $ProductAttribute->last_purchase = random_int(20, 100);
        //     $ProductAttribute->model = Str::random(6);;
        //     $ProductAttribute->unit_cost =  $this->randomFloat(20, 100, 2);
        //     $ProductAttribute->sales_rate = $this->randomFloat(20, 100, 2);
        //     $ProductAttribute->save();
        // }


        /*
         Product number 2
        $product = new Product();
        $product->name = "Product 2";
        $product->category_id = 1;
        $product->company_id = 1;
        $product->sub_category_id = 2;
        $product->created_by = 1;
        $product->save();

        $productCode = "#P0011";

        $ProductAttribute = new ProductAttribute();
        $ProductAttribute->product_id = $product->id;
        $ProductAttribute->company_id = $product->category_id;
        $ProductAttribute->code = $productCode;
        $ProductAttribute->size = "LG";
        $ProductAttribute->color = "Red";
        $ProductAttribute->current_stock = 100;
        $ProductAttribute->last_purchase = 200;
        $ProductAttribute->model = "None";
        $ProductAttribute->unit_cost = 200;
        $ProductAttribute->sales_rate = 230;
        $ProductAttribute->save();




        $productCode = "#P0022";

        $ProductAttribute = new ProductAttribute();
        $ProductAttribute->product_id = $product->id;
        $ProductAttribute->company_id = $product->category_id;
        $ProductAttribute->code = $productCode;
        $ProductAttribute->size = "XL";
        $ProductAttribute->color = "Back";
        $ProductAttribute->current_stock = 400;
        $ProductAttribute->last_purchase = 600;
        $ProductAttribute->model = "None";
        $ProductAttribute->unit_cost = 800;
        $ProductAttribute->sales_rate = 900;
        $ProductAttribute->save();

        */
    }


    function randomFloat($min, $max, $precision = 2) {
        $randomInt = random_int($min * (10 ** $precision), $max * (10 ** $precision));
        return $randomInt / (10 ** $precision);
    }
}
