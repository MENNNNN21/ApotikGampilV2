<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
     public function run(): void
    {
        AdminModel::create([
            'id' => 2,
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);
    }
}
