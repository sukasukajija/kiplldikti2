<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create('id_ID');

        function randomNik() {
            $nik = '';
            for ($i = 0; $i < 16; $i++) {
                $nik .= random_int(0, 9);
            }
            return $nik;
        }

        $mahasiswa = [
            [
                'name' => 'Budi Santoso',
                'nim' => '123456789',
                'nik' => randomNik(),
                'email' => 'budi@example.com',
                'gpa' => 3.5,
                'perguruan_tinggi_id' => 1,
                'program_studi_id' => 1,
                'jenis_kelamin' => 'L',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Siti Aminah',
                'nim' => '987654321',
                'nik' => randomNik(),
                'email' => 'siti@example.com',
                'gpa' => 3.7,
                'perguruan_tinggi_id' => 1,
                'program_studi_id' => 1,
                'jenis_kelamin' => 'P',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Ahmad Fauzan',
                'nim' => '112233445',
                'nik' => randomNik(),
                'email' => 'ahmad@example.com',
                'gpa' => 3.2,
                'perguruan_tinggi_id' => 1,
                'program_studi_id' => 1,
                'jenis_kelamin' => 'L',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Rina Kartika',
                'nim' => '556677889',
                'nik' => randomNik(),
                'email' => 'rina@example.com',
                'gpa' => 3.8,
                'perguruan_tinggi_id' => 1,
                'program_studi_id' => 1,
                'jenis_kelamin' => 'P',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Dian Purnama',
                'nim' => '667788990',
                'nik' => randomNik(),
                'email' => 'dian@example.com',
                'gpa' => 3.6,
                'perguruan_tinggi_id' => 1,
                'program_studi_id' => 1,
                'jenis_kelamin' => 'L',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Eko Wijaya',
                'nim' => '998877665',
                'nik' => randomNik(),
                'email' => 'eko@example.com',
                'gpa' => 3.3,
                'perguruan_tinggi_id' => 1,
                'program_studi_id' => 1,
                'jenis_kelamin' => 'L',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Lina Kusuma',
                'nim' => '334455667',
                'nik' => randomNik(),
                'email' => 'lina@example.com',
                'gpa' => 3.9,
                'perguruan_tinggi_id' => 2,
                'program_studi_id' => 2,
                'jenis_kelamin' => 'P',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Fajar Nugroho',
                'nim' => '223344556',
                'nik' => randomNik(),
                'email' => 'fajar@example.com',
                'gpa' => 3.4,
                'perguruan_tinggi_id' => 2,
                'program_studi_id' => 2,
                'jenis_kelamin' => 'L',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Nadia Putri',
                'nim' => '778899002',
                'nik' => randomNik(),
                'email' => 'nadia@example.com',
                'gpa' => 3.2,
                'perguruan_tinggi_id' => 2,
                'program_studi_id' => 2,
                'jenis_kelamin' => 'P',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ],
            [
                'name' => 'Yusuf Hidayat',
                'nim' => '556677443',
                'nik' => randomNik(),
                'email' => 'yusuf@example.com',
                'gpa' => 3.7,
                'perguruan_tinggi_id' => 2,
                'program_studi_id' => 2,
                'jenis_kelamin' => 'L',
                'status_mahasiswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
                'tanggal_lahir' => date('Y-m-d', strtotime('-'.rand(18, 25).' years')),
                'alamat' => 'Jalan '.rand(1, 100).' Gang '.rand(1, 10).' No '.rand(1, 100)
            ]
        ];

        $records = [];
        foreach ($mahasiswa as $base) {
            $records[] = array_merge($base, [
                // Kolom template:
                'no_pendaftaran'            => 'PDTR-' . $faker->unique()->numerify('########'),
                'no_kk'                     => $faker->numerify('################'),
                'nik_kepala_keluarga'       => $faker->numerify('################'),
                'nisn'                      => $faker->numerify('##########'),
                'status_dtks'               => $faker->randomElement(['Terdata','Tidak_terdata']),
                'status_p3ke'               => $faker->randomElement(['Aktif','Non-Aktif']),
                'no_kip'                    => 'KIP' . $faker->numerify('######'),
                'no_kks'                    => 'KKS' . $faker->numerify('######'),
                'asal_sekolah'              => $faker->company,
                'kab_kota_sekolah'          => $faker->city,
                'provinsi_sekolah'          => $faker->randomElement(['Jawa Barat','Jawa Timur','DKI Jakarta','Bali']),
                'tempat_lahir'              => $faker->city,
                'no_handphone'              => $faker->phoneNumber,
                'nama_ayah'                 => $faker->name('male'),
                'pekerjaan_ayah'            => $faker->jobTitle,
                'penghasilan_ayah'          => $faker->numberBetween(1_000_000,10_000_000),
                'status_ayah'               => $faker->randomElement(['Hidup','Meninggal']),
                'nama_ibu'                  => $faker->name('female'),
                'pekerjaan_ibu'             => $faker->jobTitle,
                'penghasilan_ibu'           => $faker->numberBetween(1_000_000,10_000_000),
                'status_ibu'                => $faker->randomElement(['Hidup','Meninggal']),
                'jumlah_tanggungan'         => $faker->numberBetween(0,5),
                'kepemilikan_rumah'         => $faker->randomElement(['Milik Sendiri','Kontrak','Sewa']),
                'tahun_perolehan'           => $faker->year,
                'sumber_listrik'            => $faker->randomElement(['PLN','Non-PLN']),
                'luas_tanah'                => $faker->numberBetween(30,200),
                'luas_bangunan'             => $faker->numberBetween(20,150),
                'sumber_air'                => $faker->randomElement(['PDAM','Sumur','Air Kemasan']),
                'mck'                       => $faker->randomElement(['Ya','Tidak']),
                'jarak_pusat_kota_km'       => $faker->randomFloat(2,1,50),
                'seleksi_penetapan'         => $faker->randomElement(['Online','Offline']),
                'ukt_spp'                   => $faker->numberBetween(500_000,5_000_000),
                'ranking_penetapan'         => $faker->numberBetween(1,10),
                'semester'                  => $faker->numberBetween(1,8),
                'skema_bantuan_pembiayaan'  => $faker->randomElement(['Beasiswa Prestasi','Beasiswa Kemiskinan','Beasiswa Olahraga']),
                'prestasi'                  => $faker->sentence(3),
            ]);
        }


        foreach ($records as $mhs) {
            Mahasiswa::create($mhs);
        }
    }
}
