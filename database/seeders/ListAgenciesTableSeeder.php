<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListAgenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_agencies')->delete();
        
        \DB::table('list_agencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Department Of Science And Technology - I',
                'code' => 'R1',
                'acronym' => 'DOST-I',
                'website' => 'www.isko-r1.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '010000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Department Of Science And Technology - II',
                'code' => 'R2',
                'acronym' => 'DOST-II',
                'website' => 'www.isko-r2.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '020000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Department Of Science And Technology - III',
                'code' => 'R3',
                'acronym' => 'DOST-III',
                'website' => 'www.isko-r3.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '030000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Department Of Science And Technology - IVA-L1',
                'code' => 'R4AL1',
                'acronym' => 'DOST-IVA-L1',
                'website' => 'www.isko-r4al1.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '040000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Department Of Science And Technology - IVA-L2',
                'code' => 'R4AL2',
                'acronym' => 'DOST-IVA-L2',
                'website' => 'www.isko-r4al2.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '030000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Department Of Science And Technology - IVB',
                'code' => 'R4B',
                'acronym' => 'DOST-IVB',
                'website' => 'www.isko-r4b.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '170000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Department Of Science And Technology - V',
                'code' => 'R5',
                'acronym' => 'DOST-V',
                'website' => 'www.isko-r5.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '050000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Department Of Science And Technology - VI',
                'code' => 'R6',
                'acronym' => 'DOST-VI',
                'website' => 'www.isko-r6.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '060000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Department Of Science And Technology - VII',
                'code' => 'R7',
                'acronym' => 'DOST-VII',
                'website' => 'www.isko-r7.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '070000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Department Of Science And Technology - VIII',
                'code' => 'R8',
                'acronym' => 'DOST-VIII',
                'website' => 'www.isko-r8.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '080000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Department Of Science And Technology - IX',
                'code' => 'R9',
                'acronym' => 'DOST-IX',
                'website' => 'www.isko-r9.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '090000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Department Of Science And Technology - X',
                'code' => 'R10',
                'acronym' => 'DOST-X',
                'website' => 'www.isko-10.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '100000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Department Of Science And Technology - XI',
                'code' => 'R11',
                'acronym' => 'DOST-XI',
                'website' => 'www.isko-11.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '110000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Department Of Science And Technology - XII-L1',
                'code' => 'R12L1',
                'acronym' => 'DOST-XII-L1',
                'website' => 'www.isko-12l1.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '120000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Department Of Science And Technology - XII-L2',
                'code' => 'R12L2',
                'acronym' => 'DOST-XII-L2',
                'website' => 'www.isko-12l2.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '120000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Department Of Science And Technology - XIII',
                'code' => 'R13',
                'acronym' => 'DOST-XIII',
                'website' => 'www.isko-r13.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '160000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Department Of Science And Technology - Cordillera Administrative Region',
                'code' => 'CAR',
                'acronym' => 'DOST-CAR',
                'website' => 'www.isko-car.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '140000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Department Of Science And Technology - Bangsamoro Autonomous Region In Muslim Mindanao',
                'code' => 'BARMM',
                'acronym' => 'DOST-BARMM',
                'website' => 'www.isko-barmm.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '150000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Department Of Science And Technology - National Capital Region',
                'code' => 'NCR',
                'acronym' => 'DOST-NCR',
                'website' => 'www.isko-ncr.com',
                'avatar' => 'avatar.jpg',
                'status' => 'Active',
                'region_code' => '130000000',
                'created_at' => '2022-05-06 09:26:49',
                'updated_at' => '2022-05-06 09:26:49',
            ),
        ));
        
        
    }
}