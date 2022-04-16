<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'admin@dost.com',
                'email_verified_at' => '2022-02-21 08:08:13',
                'password' => '$2y$10$RnZcTUb5A2vTRIpJzgYXfOsQsHXAtksvcv/4UZNow/e4bzpKP6/2y',
                'avatar' => 'avatar.jpg',
                'role' => 'Super Administrator',
                'is_active' => 0,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2022-02-21 08:08:13',
                'updated_at' => '2022-02-21 08:08:13',
            ),
            1 => 
            array (
                'id' => 3,
                'email' => 'martinwee@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$BnQsHCejtu1E3Nf5BGgpaepIfaauUvB6TJ3X2b8Ml/tmBH3Y7XEl2',
                'avatar' => 'wee-3.png',
                'role' => 'Regional Director',
                'is_active' => 0,
                'welcome_valid_until' => '2022-02-22 08:15:09',
                'remember_token' => NULL,
                'created_at' => '2022-02-21 08:15:09',
                'updated_at' => '2022-02-21 08:15:09',
            ),
            2 => 
            array (
                'id' => 5,
                'email' => 'josephine@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$WZsOK0f.hDCJCY4uasvpWO0aF8AlqWC0JFBa8sQNFR2j1aicAuVLu',
                'avatar' => 'honay-5.png',
                'role' => 'Scholarship Coordinator',
                'is_active' => 0,
                'welcome_valid_until' => '2022-02-22 08:16:31',
                'remember_token' => NULL,
                'created_at' => '2022-02-21 08:16:31',
                'updated_at' => '2022-02-21 08:16:31',
            ),
            3 => 
            array (
                'id' => 6,
                'email' => 'zoren@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$EiWVQ1M6WCbRPblQAcsmEesUx3o4uZdX5F5WyXwFtg62wQ2J6cjm.',
                'avatar' => 'antonio-6.png',
                'role' => 'Scholarship Staff',
                'is_active' => 0,
                'welcome_valid_until' => '2022-02-22 08:18:27',
                'remember_token' => NULL,
                'created_at' => '2022-02-21 08:18:27',
                'updated_at' => '2022-02-21 08:18:27',
            ),
            4 => 
            array (
                'id' => 7,
                'email' => 'bernardo@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$HagKkIKm5ClqtwsoUbpR9uL/H2Fwqb/B4ncoZaCrqn1fqgkUMiKzS',
                'avatar' => 'bernardo-7.png',
                'role' => 'Scholarship Staff',
                'is_active' => 0,
                'welcome_valid_until' => '2022-02-22 08:21:11',
                'remember_token' => NULL,
                'created_at' => '2022-02-21 08:21:11',
                'updated_at' => '2022-02-21 08:21:11',
            ),
            5 => 
            array (
                'id' => 8,
                'email' => 'alegre@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$l4vrRFdt9hDIprFXekqUlOq7QXDvagM/j4rWEemmBQh6EWh.gUtgS',
                'avatar' => 'alegre-8.png',
                'role' => 'Scholarship Staff',
                'is_active' => 0,
                'welcome_valid_until' => NULL,
                'remember_token' => NULL,
                'created_at' => '2022-02-21 08:23:08',
                'updated_at' => '2022-02-21 08:23:08',
            ),
        ));
        
        
    }
}