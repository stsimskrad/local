<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolCoursesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('school_courses')->delete();
        
        \DB::table('school_courses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'years' => 4,
                'type' => 'n/a',
                'school_id' => 1,
                'course_id' => 48,
                'created_at' => '2022-05-06 09:27:00',
                'updated_at' => '2022-05-06 09:27:00',
            ),
        ));
        
        
    }
}