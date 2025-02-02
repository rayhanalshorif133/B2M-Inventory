<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'inventory-manager']);
        Role::create(['name' => 'stock-keeper']);
        Role::create(['name' => 'purchasing-agent']);
        Role::create(['name' => 'warehouse-supervisor']);
        Role::create(['name' => 'inventory-analyst']);



        // company
        $company = new Company();
        $company->name = 'Test Company';
        $company->logo = url('logo.png');
        $company->email = 'test@b2m-tech.com';
        $company->address = 'Dhaka';
        $company->phone = '01923849384';
        $company->other_info = 'None';
        $company->save();


        $user = new User();
        $user->name = 'super-admin';
        $user->company_id = $company->id;
        $user->email = "admin@b2m-tech.com";
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole('super-admin');


        $test_user = new User();
        $test_user->name = 'Test User';
        $test_user->company_id = $company->id;
        $test_user->email = "test@b2m-tech.com";
        $test_user->password = Hash::make('password');
        $test_user->save();
        $test_user->assignRole('super-admin');


        // some categories
        $category = new Category();
        $category->company_id = $company->id;
        $category->name = 'Test Category';
        $category->status = 1;
        $category->parent_category_id = null;
        $category->created_by = $test_user->id;
        $category->save();

        $subCategory = new Category();
        $subCategory->company_id = $company->id;
        $subCategory->name = 'Test Sub Category 1';
        $subCategory->status = 1;
        $subCategory->parent_category_id = $category->id;
        $subCategory->created_by = $test_user->id;
        $subCategory->save();

        $subCategory = new Category();
        $subCategory->company_id = $company->id;
        $subCategory->name = 'Test Sub Category 2';
        $subCategory->status = 1;
        $subCategory->parent_category_id = $category->id;
        $subCategory->created_by = $test_user->id;
        $subCategory->save();


        // Supplier
        $supplier = new Supplier();
        $supplier->name = 'Test Supplier';
        $supplier->contact = '01928392839';
        $supplier->address = 'Dhaka';
        $supplier->email = 'testsupplier@example.com';
        $supplier->company_id = 1;
        $supplier->others_info = 'Nothing';
        $supplier->added_by = 2;
        $supplier->save();


        for ($index=0; $index < 5; $index++) {
            $supplier = new Supplier();
            $supplier->name = 'Test Supplier - ' . $index;
            $supplier->contact = '019283928323';
            $supplier->address = 'Dhaka';
            $supplier->email = 'testsupplier__' . $index .'@example.com';
            $supplier->company_id = 1;
            $supplier->others_info = 'Nothing';
            $supplier->added_by = 2;
            $supplier->save();
        }


        // Supplier
        $supplier = new Customer();
        $supplier->name = 'Test Customer';
        $supplier->contact = '01928392839';
        $supplier->address = 'Dhaka';
        $supplier->email = 'testcustomer@example.com';
        $supplier->company_id = 1;
        $supplier->others_info = 'Nothing';
        $supplier->added_by = 2;
        $supplier->save();


        for ($index=0; $index < 5; $index++) {
            $supplier = new Customer();
            $supplier->name = 'Test Customer - ' . $index;
            $supplier->contact = '019283928323';
            $supplier->address = 'Dhaka';
            $supplier->email = 'testcustomer__' . $index .'@example.com';
            $supplier->company_id = 1;
            $supplier->others_info = 'Nothing';
            $supplier->added_by = 2;
            $supplier->save();
        }


    }
}
