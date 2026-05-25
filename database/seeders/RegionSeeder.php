<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('kecamatan')->truncate();
        DB::table('kota')->truncate();
        DB::table('provinsi')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = json_decode(
            Storage::disk('app')->get('regions/regions.json'),
            true
        );

        foreach ($data as $provinsi) {

            DB::table('provinsi')->insert([
                'id' => $provinsi['id'],
                'nama' => $provinsi['name'],
            ]);

            foreach ($provinsi['kota'] as $kota) {

                DB::table('kota')->insert([
                    'id' => $kota['id'],
                    'provinsi_id' => $provinsi['id'],
                    'nama' => $kota['name'],
                ]);

                foreach ($kota['kecamatan'] as $kecamatan) {

                    DB::table('kecamatan')->insert([
                        'id' => $kecamatan['id'],
                        'kota_id' => $kota['id'],
                        'nama' => $kecamatan['name'],
                    ]);
                }
            }
        }
    }
}
