<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolSemestersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('school_semesters')->delete();
        
        \DB::table('school_semesters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'academic_year' => '2022-2023',
                'start_at' => '2022-03-01',
                'end_at' => '2022-07-01',
                'semester_id' => 9,
                'school_id' => 1,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
        ));
        
        
    }
}