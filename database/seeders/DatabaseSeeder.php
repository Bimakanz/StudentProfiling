<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin12345',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-08-15',
            'agama' => 'Islam',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Merdeka No. 1, Kota Bandung, Jawa Barat',
            'sosmed' => 'github.com/admin',
            'jurusan' => 'Teknik Mesin',
            'kelas' => 'XII-A',
        ]);
    }
}
