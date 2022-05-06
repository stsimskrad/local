<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolCampusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('school_campuses')->delete();
        
        \DB::table('school_campuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'shortcut' => 'WMSU',
                'campus' => 'MAIN',
                'address' => 'normal road, baliwasan',
                'is_main' => 1,
                'municipality_code' => '097332000',
                'school_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'shortcut' => 'ADZU',
                'campus' => 'MAIN',
                'address' => 'La Purisima St',
                'is_main' => 1,
                'municipality_code' => '097332000',
                'school_id' => 2,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'shortcut' => 'UZ',
                'campus' => 'MAIN',
                'address' => 'La Purisima St',
                'is_main' => 1,
                'municipality_code' => '097332000',
                'school_id' => 3,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'shortcut' => 'ZSCMST',
                'campus' => 'MAIN',
                'address' => 'Fort Pilar',
                'is_main' => 1,
                'municipality_code' => '097332000',
                'school_id' => 4,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'shortcut' => 'ZCSPC',
                'campus' => 'MAIN',
                'address' => 'R.T. Lim, Blvd.',
                'is_main' => 1,
                'municipality_code' => '097332000',
                'school_id' => 5,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'shortcut' => 'PILAR',
                'campus' => 'MAIN',
                'address' => 'R.T. Lim, Blvd.',
                'is_main' => 1,
                'municipality_code' => '097332000',
                'school_id' => 6,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'shortcut' => 'JRMSU',
                'campus' => 'MAIN',
                'address' => 'Gov. Sta. Cruz, Guading Adasa St',
                'is_main' => 1,
                'municipality_code' => '097201000',
                'school_id' => 7,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'shortcut' => 'ABC',
                'campus' => 'MAIN',
                'address' => 'Quezon Avenue College Park',
                'is_main' => 1,
                'municipality_code' => '097202000',
                'school_id' => 8,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            8 => 
            array (
                'id' => 10,
                'shortcut' => 'SCC',
                'campus' => 'MAIN',
                'address' => 'Corner Cerilles & Sagun St.',
                'is_main' => 1,
                'municipality_code' => '097322000',
                'school_id' => 10,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            9 => 
            array (
                'id' => 11,
                'shortcut' => 'SVC',
                'campus' => 'MAIN',
                'address' => 'Padre Ramon St., Estaka',
                'is_main' => 1,
                'municipality_code' => '097202000',
                'school_id' => 11,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            10 => 
            array (
                'id' => 12,
                'shortcut' => 'DCIT',
                'campus' => 'MAIN',
                'address' => 'Dapitan Road',
                'is_main' => 1,
                'municipality_code' => '097202000',
                'school_id' => 12,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            11 => 
            array (
                'id' => 13,
                'shortcut' => 'DMC',
                'campus' => 'MAIN',
                'address' => 'Fr. Patangan Road, Sta. FIlomena St.',
                'is_main' => 1,
                'municipality_code' => '097202000',
                'school_id' => 13,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            12 => 
            array (
                'id' => 14,
                'shortcut' => 'SMC',
                'campus' => 'MAIN',
                'address' => 'Jamisola St, Sta.Lucia',
                'is_main' => 1,
                'municipality_code' => '097322000',
                'school_id' => 14,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            13 => 
            array (
                'id' => 15,
                'shortcut' => 'SJCSI',
                'campus' => 'MAIN',
                'address' => 'Jose Burgos St., National Highway',
                'is_main' => 1,
                'municipality_code' => '097218000',
                'school_id' => 15,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            14 => 
            array (
                'id' => 16,
                'shortcut' => 'JHCSC',
                'campus' => 'MAIN',
                'address' => 'National Highway, Brgy, San Miguel',
                'is_main' => 1,
                'municipality_code' => '097322000',
                'school_id' => 16,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            15 => 
            array (
                'id' => 17,
                'shortcut' => 'MSU',
                'campus' => 'MAIN',
                'address' => 'marawi',
                'is_main' => 1,
                'municipality_code' => '153617000',
                'school_id' => 17,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            16 => 
            array (
                'id' => 18,
                'shortcut' => 'MSU-Buug',
                'campus' => 'BUUG',
                'address' => 'Datu Panas St',
                'is_main' => 0,
                'municipality_code' => '098302000',
                'school_id' => 17,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            17 => 
            array (
                'id' => 19,
                'shortcut' => 'MSU-Sindangan',
                'campus' => 'SINDANGAN',
                'address' => 'Extension',
                'is_main' => 0,
                'municipality_code' => '097218000',
                'school_id' => 17,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            18 => 
            array (
                'id' => 20,
                'shortcut' => 'WMSU-Ipil',
                'campus' => 'IPIL',
                'address' => 'WMSU Rd, Ipil Heights',
                'is_main' => 0,
                'municipality_code' => '098305000',
                'school_id' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}