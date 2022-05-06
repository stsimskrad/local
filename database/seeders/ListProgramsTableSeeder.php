<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListProgramsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_programs')->delete();
        
        \DB::table('list_programs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'RA 7687',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Ra 10612',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Merit',
                'others' => 'n/a',
                'is_sub' => 0,
                'is_active' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'JLAP',
                'others' => 'n/a',
                'is_sub' => 1,
                'is_active' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'GREAT-M',
                'others' => 'n/a',
                'is_sub' => 1,
                'is_active' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'RA 7687 Sophomore',
                'others' => 'n/a',
                'is_sub' => 1,
                'is_active' => 1,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}