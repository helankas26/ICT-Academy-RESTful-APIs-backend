<?php

namespace Database\Seeders;

use App\Services\Implementation\IDGeneratorService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IDGeneratorService $IDGeneratorService)
    {
        DB::table('branches')->insert([
            'branchID' => $IDGeneratorService->branchID(),
            'branchName' => 'Hakmana',
            'telNo' => '0769198533',
            'address' => 'ICT Academy, Beliatta road, Hakmana',
            'noOfRooms' => '4',
        ]);
    }
}
