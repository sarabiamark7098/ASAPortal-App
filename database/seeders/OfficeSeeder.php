<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'All DSWD Field Office XI', 'code' => 'XI-FO-ALL', 'division_id' => null],
            ['id' => 4, 'name' => 'Office of the Regional Director', 'code' => 'XI-FO-ORD', 'division_id' => null],
            ['id' => 7, 'name' => 'Pantawid - Capability Building Division', 'code' => 'XI-FO-4PS-CBS', 'division_id' => null],
            ['id' => 24, 'name' => 'Administrative Division', 'code' => 'XI-FO-AD', 'division_id' => null],
            ['id' => 39, 'name' => 'Disaster Response Management Division', 'code' => 'XI-FO-DRMD', 'division_id' => null],
            ['id' => 43, 'name' => 'Financial Management Division', 'code' => 'XI-FO-FMD', 'division_id' => null],
            ['id' => 47, 'name' => 'Human Resource Management and Development Division', 'code' => 'XI-FO-HRMDD', 'division_id' => null],
            ['id' => 58, 'name' => 'Policy and Plans Division', 'code' => 'XI-FO-PPD', 'division_id' => null],
            ['id' => 64, 'name' => 'Promotive Service Division', 'code' => 'XI-FO-PROMSD', 'division_id' => null],
            ['id' => 67, 'name' => 'Protective Service Division', 'code' => 'XI-FO-PSD', 'division_id' => null],
            ['id' => 68, 'name' => 'Capacity Building Section', 'code' => 'XI-FO-PSD-CBS', 'division_id' => 67],
            ['id' => 69, 'name' => 'Center Based Services Section', 'code' => 'XI-FO-PSD-CBSS', 'division_id' => 67],
            ['id' => 70, 'name' => 'Crisis Intervention Section', 'code' => 'XI-FO-PSD-CIS', 'division_id' => 67],
            ['id' => 71, 'name' => 'Community Based Services Section', 'code' => 'XI-FO-PSD-COMBS', 'division_id' => 67],
            ['id' => 2, 'name' => 'Bids and Awards Committee', 'code' => 'XI-FO-BAC', 'division_id' => 24],
            ['id' => 3, 'name' => 'Commision on Audit', 'code' => 'XI-FO-COA', 'division_id' => 4],
            ['id' => 5, 'name' => 'Pantawid - Administrative Section', 'code' => 'XI-FO-4PS-AS', 'division_id' => 7],
            ['id' => 6, 'name' => 'Pantawid - Beneficiary Data Management Section', 'code' => 'XI-FO-4PS-BDM', 'division_id' => 7],
            ['id' => 8, 'name' => 'Pantawid - Compliance Verification Section', 'code' => 'XI-FO-4PS-CVS', 'division_id' => 7],
            ['id' => 9, 'name' => 'Pantawid - Family Development Section', 'code' => 'XI-FO-4PS-FDS', 'division_id' => 7],
            ['id' => 10, 'name' => 'Pantawid - Grievance Redress Section', 'code' => 'XI-FO-4PS-GRS', 'division_id' => 7],
            ['id' => 11, 'name' => 'Pantawid - Institutional Partnership Section', 'code' => 'XI-FO-4PS-IPD', 'division_id' => 7],
            ['id' => 12, 'name' => 'Pantawid - Modified Conditional Cash Transfer Section', 'code' => 'XI-FO-4PS-MCCT', 'division_id' => 7],
            ['id' => 13, 'name' => 'Pantawid - Operation', 'code' => 'XI-FO-4PS-OPS', 'division_id' => 7],
            ['id' => 14, 'name' => 'Pantawid - Planning and Monitoring and Evaluation Section', 'code' => 'XI-FO-4PS-PMES', 'division_id' => 7],
            ['id' => 15, 'name' => 'Pantawid Operations Office Davao City', 'code' => 'XI-FO-4PS-POO-DC', 'division_id' => 7],
            ['id' => 16, 'name' => 'Pantawid Operations Office Davao del Norte', 'code' => 'XI-FO-4PS-POO-DDN', 'division_id' => 7],
            ['id' => 17, 'name' => 'Pantawid Operations Office Davao de Oro', 'code' => 'XI-FO-4PS-POO-DDO', 'division_id' => 7],
            ['id' => 18, 'name' => 'Pantawid Operations Office Davao del Sur', 'code' => 'XI-FO-4PS-POO-DDS', 'division_id' => 7],
            ['id' => 19, 'name' => 'Pantawid Operations Office Davao Oriental', 'code' => 'XI-FO-4PS-POO-DO', 'division_id' => 7],
            ['id' => 20, 'name' => 'Pantawid Operations Office Davao Occidental', 'code' => 'XI-FO-4PS-POO-DOCC', 'division_id' => 7],
            ['id' => 21, 'name' => 'Pantawid Regional Program Management Office', 'code' => 'XI-FO-4PS-RPMO', 'division_id' => 7],
            ['id' => 22, 'name' => 'Pantawid - Social Marketing Unit', 'code' => 'XI-FO-4PS-SMU', 'division_id' => 7],
            ['id' => 23, 'name' => 'Pantawid - Social Services Delivery and Management Section', 'code' => 'XI-FO-4PS-SSDMS', 'division_id' => 7],
            ['id' => 25, 'name' => 'General Service Section', 'code' => 'XI-FO-AD-GSS', 'division_id' => 24],
            ['id' => 26, 'name' => 'Procurement Section', 'code' => 'XI-FO-AD-PS', 'division_id' => 24],
            ['id' => 27, 'name' => 'Property and Supply Section', 'code' => 'XI-FO-AD-PSS', 'division_id' => 24],
            ['id' => 28, 'name' => 'Records and Management Section', 'code' => 'XI-FO-AD-RAMS', 'division_id' => 24],
            ['id' => 29, 'name' => 'Minors Travelling Abroad Office', 'code' => 'XI-FO-CBS-MTA', 'division_id' => 68],
            ['id' => 30, 'name' => 'Angels Haven', 'code' => 'XI-FO-CBSS-AH', 'division_id' => 69],
            ['id' => 31, 'name' => 'A/NVRC Island Cluster', 'code' => 'XI-FO-CBSS-ANVRC', 'division_id' => 69],
            ['id' => 32, 'name' => 'Home for the Aged', 'code' => 'XI-FO-CBSS-HA', 'division_id' => 69],
            ['id' => 33, 'name' => 'Home for Girls and Women', 'code' => 'XI-FO-CBSS-RHGW', 'division_id' => 69],
            ['id' => 34, 'name' => 'Reception and Study Center for Children', 'code' => 'XI-FO-CBSS-RSCC', 'division_id' => 69],
            ['id' => 35, 'name' => 'Regional Rehabilitation Center for Youth', 'code' => 'XI-FO-CBSS-RRCY', 'division_id' => 69],
            ['id' => 36, 'name' => 'Regional Alternative Child Care Office', 'code' => 'XI-FO-ORD-RACCO', 'division_id' => 67],
            ['id' => 37, 'name' => 'Supplementary Feeding Program', 'code' => 'XI-FO-COMBS-SFP', 'division_id' => 71],
            ['id' => 38, 'name' => 'Social Pension Office', 'code' => 'XI-FO-COMBS-SPO', 'division_id' => 71],
            ['id' => 40, 'name' => 'Regional Response & Information Management Section', 'code' => 'XI-FO-DRMD-DRIMS', 'division_id' => 39],
            ['id' => 41, 'name' => 'Disaster Response Rehabilitation Managment Section', 'code' => 'XI-FO-DRMD-DRRMS', 'division_id' => 39],
            ['id' => 42, 'name' => 'Regional Resource Operation Section', 'code' => 'XI-FO-DRMD-RROS', 'division_id' => 39],
            ['id' => 44, 'name' => 'Accounting Section', 'code' => 'XI-FO-FMD-AS', 'division_id' => 43],
            ['id' => 45, 'name' => 'Budget Section', 'code' => 'XI-FO-FMD-BS', 'division_id' => 43],
            ['id' => 46, 'name' => 'Cash Section', 'code' => 'XI-FO-FMD-CS', 'division_id' => 43],
            ['id' => 48, 'name' => 'Human Resource Planning and Performance Management Section', 'code' => 'XI-FO-HRMDD-HRPPMS', 'division_id' => 47],
            ['id' => 49, 'name' => 'Human Resource Welfare Section', 'code' => 'XI-FO-HRMDD-HRWS', 'division_id' => 47],
            ['id' => 50, 'name' => 'Learning and Development Section', 'code' => 'XI-FO-HRMDD-LDS', 'division_id' => 47],
            ['id' => 51, 'name' => 'Personal Administration Section', 'code' => 'XI-FO-HRMDD-PAS', 'division_id' => 47],
            ['id' => 52, 'name' => 'Internal Audit Unit', 'code' => 'XI-FO-IAU', 'division_id' => 4],
            ['id' => 53, 'name' => 'Kalhi-CIDSS PMO', 'code' => 'XI-FO-KC', 'division_id' => 64],
            ['id' => 54, 'name' => 'Legal Unit', 'code' => 'XI-FO-LU', 'division_id' => 4],
            ['id' => 55, 'name' => 'Office of Assistant Regional Director for Administration', 'code' => 'XI-FO-OARDA', 'division_id' => 4],
            ['id' => 56, 'name' => 'Office of Assistant Regional Director for Operation', 'code' => 'XI-FO-OARDO', 'division_id' => 4],
            ['id' => 57, 'name' => 'Social Technology Unit', 'code' => 'XI-FO-ORD-STU', 'division_id' => 4],
            ['id' => 59, 'name' => 'Regional Information & Communication Technology Management Section', 'code' => 'XI-FO-PPD-ICT', 'division_id' => 58],
            ['id' => 60, 'name' => 'National Household Targetting Section', 'code' => 'XI-FO-PPD-NHTS', 'division_id' => 58],
            ['id' => 61, 'name' => 'Policy Development and Planning Section', 'code' => 'XI-FO-PPD-PDPS', 'division_id' => 58],
            ['id' => 62, 'name' => 'Standard Section', 'code' => 'XI-FO-PPD-SS', 'division_id' => 58],
            ['id' => 63, 'name' => 'Unconditional Cash Transfer', 'code' => 'XI-FO-PPD-UCT', 'division_id' => 58],
            ['id' => 65, 'name' => 'Enhance Partnership Against Hunger and Poverty', 'code' => 'XI-FO-PROMSD-EPAHP', 'division_id' => 4],
            ['id' => 66, 'name' => 'Sustainable Livelihood Program PMO', 'code' => 'XI-FO-PROMSD-SLP', 'division_id' => 64],
            ['id' => 72, 'name' => 'Social Marketing Unit', 'code' => 'XI-FO-SMU', 'division_id' => 4],
            ['id' => 73, 'name' => 'Social Welfare and Development Office- Davao City Third District', 'code' => 'XI-FO-SWAD-DC', 'division_id' => 70],
            ['id' => 74, 'name' => 'Social Welfare and Development Office- Davao del Norte', 'code' => 'XI-FO-SWAD-DDN', 'division_id' => 70],
            ['id' => 75, 'name' => 'Social Welfare and Development Office- Davao de Oro', 'code' => 'XI-FO-SWAD-DDO', 'division_id' => 70],
            ['id' => 76, 'name' => 'Social Welfare and Development Office- Davao del Sur', 'code' => 'XI-FO-SWAD-DDS', 'division_id' => 70],
            ['id' => 77, 'name' => 'Social Welfare and Development Office- Davao Oriental', 'code' => 'XI-FO-SWAD-DO', 'division_id' => 70],
            ['id' => 78, 'name' => 'Social Welfare and Development Office- Davao Occidental', 'code' => 'XI-FO-SWAD-DOCC', 'division_id' => 70],
            ['id' => 79, 'name' => 'Regional Juvenile Justice and Welfare Council', 'code' => 'XI-FO-RJJWC', 'division_id' => 67],
            ['id' => 80, 'name' => 'Regional Sub-Committee for the Welfare of Children', 'code' => 'XI-FO-RSCWC', 'division_id' => 67],
            ['id' => 81, 'name' => 'Technical/Advisor Assistance and other related Support Services', 'code' => 'XI-FO-ORD-TAAORSS', 'division_id' => 4],
        ];
        foreach ($data as $office) {
            DB::table('offices')->updateOrInsert(
                ['id' => $office['id']],
                [
                    'name' => $office['name'],
                    'code' => $office['code'],
                    'division_id' => $office['division_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

    }
}
