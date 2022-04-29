<?php

namespace Database\Seeders;

use App\Services\Implementation\IDGeneratorService;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IDGeneratorService $IDGeneratorService)
    {
        DB::table('users')->insert([
            'userID' => $IDGeneratorService->userID(),
            'userName' => 'SuperAdmin',
            'password' => Hash::make('adminSuper2018'),
            'privilege' => 'Super',
            'employeeID' => 'STAFF001',
            'status' => 'Active'
        ]);
    }
}
