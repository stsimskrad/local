<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('posts')->delete();
        
        \DB::table('posts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'STSIMS version 1 released.',
            'content' => 'The Science and Technology Scholarship Information Management System (STSIMS) is a database system intended for the implementation of DOST’s scholarship provision for talented and qualified young Filipinos in the Philippines, monitored and enforced by the Science Education Institute (SEI).',
                'attachment' => 'default.jpg',
                'start_at' => '2022-05-14 09:54:44',
                'end_at' => '2022-05-14 09:54:44',
                'type_id' => 48,
                'user_id' => 1,
                'created_at' => '2022-05-14 17:54:44',
                'updated_at' => '2022-05-14 17:54:44',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'The DOST-SEI is proud to announce the qualifiers for the 2021 Junior Level Science Scholarships! ',
                'content' => 'Congratulations, scholars! May your journey as science scholars pave the way to a brighter future for our nation.

Check the full list of qualifiers here: https://www.sei.dost.gov.ph/2021jlss

List of qualifiers is also published on selected broadsheets and print outlets.',
                'attachment' => 'post-1.jpg',
                'start_at' => '2022-05-14 09:57:20',
                'end_at' => '2022-05-14 09:57:20',
                'type_id' => 48,
                'user_id' => 1,
                'created_at' => '2022-05-14 17:57:20',
                'updated_at' => '2022-05-14 17:57:20',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => '2021 DOST-SEI Undergraduate Scholars',
            'content' => 'The long wait is over for the applicants to the 2021 DOST-SEI S&T Undergraduate Scholarships as the Department of Science and Technology - Science Education Institute (DOST-SEI) announces today the names of qualifiers to the said
program.

The DOST-SEI did not conduct the national scholarship qualifying examination in 2020 due to the COVID-19 pandemic.
The Institute employed data analytics and proxy indicators in place of the exam to identify qualifiers.

Documentary requirements were collected through the agency’s E-Scholarship Application System beginning June 2020.
These documents, including the students’ grades in Grades 9-11, which were obtained and verified from their respective
schools, were evaluated.',
                'attachment' => 'post-2.jpg',
                'start_at' => '2022-05-14 10:38:56',
                'end_at' => '2022-05-14 10:38:56',
                'type_id' => 47,
                'user_id' => 1,
                'created_at' => '2022-05-14 18:38:56',
                'updated_at' => '2022-05-14 18:38:56',
            ),
        ));
        
        
    }
}