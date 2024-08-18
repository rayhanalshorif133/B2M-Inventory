<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $transactionType = new TransactionType();
        $transactionType->name = 'bkash';
        $transactionType->added_by = 1;
        $transactionType->save();

        $transactionType = new TransactionType();
        $transactionType->name = 'cash';
        $transactionType->added_by = 1;
        $transactionType->save();

        $transactionType = new TransactionType();
        $transactionType->name = 'bank';
        $transactionType->added_by = 1;
        $transactionType->save();

        $transactionType = new TransactionType();
        $transactionType->name = 'rocket';
        $transactionType->added_by = 1;
        $transactionType->save();
    }
}
