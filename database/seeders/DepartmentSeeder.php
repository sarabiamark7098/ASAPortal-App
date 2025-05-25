<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'OFFICE OF THE REGIONAL DIRECTOR' => [
                'OFFICE OF THE REGIONAL DIRECTOR'
            ],
            'ADMINISTRATIVE DIVISION' => [
                'ADMINISTRATIVE SECTION',
                'LEGAL SECTION',
                'RECORDS MANAGEMENT SECTION',
            ],
            'FINANCIAL MANAGEMENT DIVISION' => [
                'FINANCE SECTION',
                'ACCOUNTING SECTION',
                'BUDGET SECTION',
                'PROCUREMENT SECTION',
            ],
            'HUMAN RESOURCE MANAGEMENT AND DEVELOPMENT DIVISION' => [
                'HUMAN RESOURCE MANAGEMENT SECTION',
                'TRAINING AND DEVELOPMENT SECTION',
            ],
            'POLICY AND PLANS DIVISION' => [
                'PLANNING AND MONITORING SECTION',
            ],
            'PROMOTIVE DIVISION' => [
                'COMMUNITY PROGRAMS AND SERVICES SECTION',
            ],
            'PANTAWID PAMILYANG PILIPINO PROGRAM DIVISION' => [
                'SOCIAL WELFARE AND DEVELOPMENT PROGRAMS SECTION',
            ],
            'DISASTER RESPONSE AND MANAGEMENT DIVISION' => [
                'DISASTER RESPONSE AND MANAGEMENT SECTION',
            ],
        ];

        foreach ($data as $divisionName => $sections) {
            // Insert or update the division
            $divisionId = DB::table('division')->updateOrInsert(
                ['name' => $divisionName],
                ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );

            // Get the actual ID (updateOrInsert returns boolean, so fetch it manually)
            $division = DB::table('division')->where('name', $divisionName)->first();

            foreach ($sections as $sectionName) {
                DB::table('section')->updateOrInsert(
                    ['name' => $sectionName],
                    [
                        'division_id' => $division->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }
    }
}
