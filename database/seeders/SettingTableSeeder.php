<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'Toko Kita',
            'alamat' => 'Jl. Juanda 1 Perum. Batu Alam Permai',
            'telepon' => '081234567892',
            'tipe_nota' => 1, // Kecil
            'diskon' => 5,
            'path_logo' => 'img/logo.png',
            'path_kartu_member' => 'img/member.png',
        ]);
    }
}
