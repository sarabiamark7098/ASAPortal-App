<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TypeOfRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Technical Assistance Relative to Building and Grounds Management'],
            ['id' => 2, 'name' => 'Vehicle Request'],
            ['id' => 3, 'name' => 'Use Conference Room Request'],
            ];
        foreach ($data as $office) {
            DB::table('offices')->updateOrInsert(
                ['id' => $office['id']],
                [
                    'name' => $office['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
