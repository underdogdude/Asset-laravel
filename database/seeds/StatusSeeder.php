<?php

use App\StatusTable;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusTable::create([
            'name' => 'ใช้งานอยู่',
        ]);

        StatusTable::create([
            'name' => 'ชำรุด/เสื่อมสภาพ',
        ]);

        StatusTable::create([
            'name' => 'ไม่จำเป็นใช้งาน',
        ]);

        StatusTable::create([
            'name' => 'หาไม่พบ',
        ]);
    }
}
