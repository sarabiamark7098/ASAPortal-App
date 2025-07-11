<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeOfRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'Type' => 'Technical Assistance Relative to Building and Grounds Management'],
            ['id' => 2, 'Type' => 'Vehicle Request'],
            ['id' => 3, 'Type' => 'Use Conference Room Request'],
            ['id' => 4, 'Type' => ''],
            ['id' => 5, 'Type' => ''],
            ['id' => 6, 'Type' => ''],
            ['id' => 7, 'Type' => ''],
            ];
        foreach ($data as $office) {
            DB::table('offices')->updateOrInsert(
                ['id' => $office['id']],
                [
                    'type' => $office['name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
