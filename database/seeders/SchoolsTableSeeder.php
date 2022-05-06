<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schools')->delete();
        
        \DB::table('schools')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => NULL,
                'name' => 'WESTERN MINDANAO STATE UNIVERSITY',
                'avatar' => 'school.jpg',
                'class_id' => 8,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => NULL,
                'name' => 'ATENEO DE ZAMBOANGA UNIVERSITY',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => NULL,
                'name' => 'UNIVERSIDAD DE ZAMBOANGA',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => NULL,
                'name' => 'ZAMBOANGA STATE COLLEGE OF MARINE SCIENCES AND TECHNOLGY',
                'avatar' => 'school.jpg',
                'class_id' => 8,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => NULL,
                'name' => 'ZAMBOANGA CITY STATE POLYTECHNIC COLLEGE',
                'avatar' => 'school.jpg',
                'class_id' => 8,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => NULL,
                'name' => 'PILAR COLLEGE',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => NULL,
                'name' => 'JOSE RIZAL MEMORIAL STATE UNIVERSITY',
                'avatar' => 'school.jpg',
                'class_id' => 8,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => NULL,
                'name' => 'ANDRES BONIFACIO COLLEGE',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            8 => 
            array (
                'id' => 10,
                'code' => NULL,
                'name' => 'SAINT COLUMBAN COLLEGE',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            9 => 
            array (
                'id' => 11,
                'code' => NULL,
                'name' => 'SAINT VINCENT\'S COLLEGE',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            10 => 
            array (
                'id' => 12,
                'code' => NULL,
                'name' => 'DIPOLOG CITY INSTITUTE OF TECHNOLOGY',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            11 => 
            array (
                'id' => 13,
                'code' => NULL,
                'name' => 'DIPOLOG MEDICAL CENTER COLLEGE FOUNDATION INC',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            12 => 
            array (
                'id' => 14,
                'code' => NULL,
                'name' => 'SOUTHERN MINDANAO COLLEGE',
                'avatar' => 'school.jpg',
                'class_id' => 8,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            13 => 
            array (
                'id' => 15,
                'code' => NULL,
                'name' => 'ST. JOSEPH COLLEGE OF SINDANGAN INC.',
                'avatar' => 'school.jpg',
                'class_id' => 7,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            14 => 
            array (
                'id' => 16,
                'code' => NULL,
                'name' => 'JH CERILLES STATE COLLEGE',
                'avatar' => 'school.jpg',
                'class_id' => 8,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            15 => 
            array (
                'id' => 17,
                'code' => NULL,
                'name' => 'MINDANAO STATE UNIVERSITY',
                'avatar' => 'school.jpg',
                'class_id' => 8,
                'term_id' => 12,
                'grading_id' => 17,
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
        ));
        
        
    }
}