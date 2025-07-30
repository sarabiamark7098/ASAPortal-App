<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeOfRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'type' => 'Technical Assistance Relative to Building and Grounds Management'],
            ['id' => 2, 'type' => 'Use of Official Vehicle'],
            ['id' => 3, 'type' => 'Use Conference Room'],
            ['id' => 4, 'type' => 'Air Transport Order'],
            ['id' => 5, 'type' => 'Entry to DSWD Premises'],
            ['id' => 6, 'type' => 'Overnight Parking of Vehicle'],
            ['id' => 7, 'type' => 'Janitorial Services'],
            ];
        foreach ($data as $type) {
            DB::table('type_of_requests')->updateOrInsert(
                ['id' => $type['id']],
                [
                    'type' => $type['type'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
