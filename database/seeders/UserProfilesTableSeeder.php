<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_profiles')->delete();
        
        \DB::table('user_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'firstname' => 'Ra-ouf',
                'lastname' => 'Jumli',
                'middlename' => 'Indanan',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09557650803',
                'user_id' => 1,
                'created_at' => '2022-02-21 08:08:13',
                'updated_at' => '2022-02-21 08:08:13',
            ),
            1 => 
            array (
                'id' => 3,
                'firstname' => 'martin',
                'lastname' => 'wee',
                'middlename' => 'a',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123498765',
                'user_id' => 3,
                'created_at' => '2022-02-21 08:15:09',
                'updated_at' => '2022-02-21 08:15:09',
            ),
            2 => 
            array (
                'id' => 4,
                'firstname' => 'josephine',
                'lastname' => 'honay',
                'middlename' => 'b',
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09987654321',
                'user_id' => 5,
                'created_at' => '2022-02-21 08:16:31',
                'updated_at' => '2022-02-21 08:16:31',
            ),
            3 => 
            array (
                'id' => 5,
                'firstname' => 'zoren',
                'lastname' => 'antonio',
                'middlename' => 'f',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09124356879',
                'user_id' => 6,
                'created_at' => '2022-02-21 08:18:27',
                'updated_at' => '2022-02-21 08:18:27',
            ),
            4 => 
            array (
                'id' => 6,
                'firstname' => 'sheila',
                'lastname' => 'bernardo',
                'middlename' => 's',
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09214365879',
                'user_id' => 7,
                'created_at' => '2022-02-21 08:21:11',
                'updated_at' => '2022-02-21 08:21:11',
            ),
            5 => 
            array (
                'id' => 7,
                'firstname' => 'Stenel Rizza',
                'lastname' => 'Alegre',
                'middlename' => 'V',
                'suffix' => NULL,
                'gender' => 'Female',
                'mobile' => '09986754231',
                'user_id' => 8,
                'created_at' => '2022-02-21 08:23:08',
                'updated_at' => '2022-02-21 08:23:08',
            ),
        ));
        
        
    }
}