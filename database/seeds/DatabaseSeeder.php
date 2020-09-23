<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $id_karyawan = date('hms');
        DB::table('admin')->insert([
            'id' => '100',
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);

        $jabatan = [
            1 =>
            "Accounting", "Restaurant Manager", "Personalia", "Supervisor",
            "Head Chef", "Cashier", "Waiter/Waitress", "Assistant Chef"
        ];

        for ($i = 1; $i <= 8; $i++) {
            if ($i >= 4) {
                DB::table('jabatan')->insert([
                    'id' => $i,
                    'name' => $jabatan[($i)],
                    'worktime' => 40000,
                    'overtime' => 20000,
                    'food' => 15000,
                    'transport' => 10000,
                ]);
            } else {
                DB::table('jabatan')->insert([
                    'id' => $i,
                    'name' => $jabatan[$i],
                    'worktime' => 50000,
                    'overtime' => 25000,
                    'food' => 15000,
                    'transport' => 10000,
                ]);
            }
        }

        DB::table('karyawan')->insert([
            'id' => $id_karyawan.'1',
            'jabatan_id' => '3',
            'name' => 'Adam Syarif Hidayatullah',
            'username' => 'user',
            'password' => bcrypt('user'),
            'birth' => '1998-10-13',
            'start_work' => '2019-10-13',
            'phone' => '082140320499',
            'address' => 'Malang',
            'gender' => 1,
        ]);

        $faker = Faker::create('id_ID');

        $presensi_id_count = 1;
        $gaji_id_count = 1;
        for ($i = 1; $i <= 20; $i++) {
            if ($i > 1) {
                $gender = $faker->numberBetween(0, 1);
                DB::table('karyawan')->insert([
                    'id' => $id_karyawan.$i,
                    'jabatan_id' => $faker->numberBetween(1, 8),
                    'name' => $faker->name($gender),
                    'username' => $faker->userName,
                    'password' => bcrypt('dayung231'),
                    'birth' => $faker->date($format = 'Y-m-d', $max = '2000-01-01'),
                    'start_work' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'gender' => $gender,
                ]);
            }
            for ($j = 1; $j <= 70; $j++) {
                $bulan = ($j % 30 == 0 ? ((int) ($j / 30)) : ((int) ($j / 30)) + 1);
                $hari = ($j % 30 == 0 ? 30 : ($j % 30));
                $worktime = $faker->numberBetween(0, 1);
                $overtime = ($worktime == 1 ? $faker->numberBetween(0, 1) : 0);
                DB::table('presensi')->insert([
                    'id' => $presensi_id_count,
                    'karyawan_id' => $id_karyawan.$i,
                    'worktime' => $worktime,
                    'overtime' => $overtime,
                    'date' => '2020-' . ($bulan + 3) . '-' . $hari,
                ]);
                $presensi_id_count++;
            }
            for ($j = 1; $j <= 3; $j++) {
                DB::table('gaji')->insert([
                    'id' => date('hms').$gaji_id_count,
                    'karyawan_id' => $id_karyawan.$i,
                    'period' => '2020-' . ($j + 3) . '-1',
                    // 'status' => $faker->numberBetween(0, 1),
                ]);
                $gaji_id_count++;
            }
        }
    }
}
