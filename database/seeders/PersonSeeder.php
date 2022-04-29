<?php

namespace Database\Seeders;

use App\Services\Implementation\IDGeneratorService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IDGeneratorService $IDGeneratorService)
    {
        DB::table('people')->insert([
            'personID' => $IDGeneratorService->staffID(),
            'personType' => 'Employee',
            'firstName' => 'Super',
            'lastName' => 'User',
            'dob' => '1997-09-29',
            'sex' => 'Male',
            'telNo' => '0778596940',
            'address' => 'FoT, UoR',
            'email' => 'helankas26@gmail.com',
            'status' => 'Super',
            'joinedDate' => Carbon::now()->format('Y-m-d'),
        ]);
    }
}
