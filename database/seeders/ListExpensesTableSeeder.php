<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListExpensesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_expenses')->delete();
        
        \DB::table('list_expenses')->insert(array (
            0 => 
            array (
                'id' => 1,
            'name' => 'Honorarium of One (1) Project Leader',
                'code' => 'HONORARIUM-PLeader',
                'expenditure_id' => 18,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
            'name' => 'Honorarium of One (1) Project Coordinator',
                'code' => 'HONORARIUM-PCoord',
                'expenditure_id' => 18,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
            'name' => 'Honorarium of Three (3) Regional Program Support Staff',
                'code' => 'HONORARIUM-RegStaff',
                'expenditure_id' => 18,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Inter-Agency Committee Meeting',
                'code' => 'InterCOMMITTEE',
                'expenditure_id' => 18,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'University Coordinator',
                'code' => 'UnivCOORDINATOR',
                'expenditure_id' => 18,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'honorarium greatM',
                'code' => 'HgreatM',
                'expenditure_id' => 18,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Supplies and Materials, Communication Expenses, Traveling Allowances, Coordination, Meeting, Workshop and other Related Expenses',
                'code' => 'SUPPLIES-MATERIALS',
                'expenditure_id' => 19,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Tuition and Other School Fees',
                'code' => 'TOSF',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Monthly Stipends',
                'code' => 'STIPENDS',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Book allowance',
                'code' => 'bA',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'PE/MS Allowances',
                'code' => 'PMA',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Actual Transportation Allowance of Scholars',
                'code' => 'aTAS',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'STLAP',
                'code' => 'STLAP',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Group Health and Accident Insurance',
                'code' => 'GHAAI',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Financial Assistance during Summer',
                'code' => 'FADS',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Graduation Allowance',
                'code' => 'gA',
                'expenditure_id' => 20,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Capital outlay',
                'code' => 'CO',
                'expenditure_id' => 21,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}