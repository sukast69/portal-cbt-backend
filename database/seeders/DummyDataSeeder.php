<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Ruangan;
use App\Models\SubKelas;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Ruangan
        Ruangan::create(['kode_ruangan' => 'LAB-01', 'nama_ruangan' => 'Lab Komputer 1', 'kapasitas' => 30, 'lokasi' => 'Gedung A Lt.2']);
        Ruangan::create(['kode_ruangan' => 'LAB-02', 'nama_ruangan' => 'Lab Komputer 2', 'kapasitas' => 25, 'lokasi' => 'Gedung A Lt.2']);
        Ruangan::create(['kode_ruangan' => 'LAB-03', 'nama_ruangan' => 'Lab Komputer 3', 'kapasitas' => 35, 'lokasi' => 'Gedung B Lt.1']);

        // Kelas
        $kelasX = Kelas::create(['nama_kelas' => 'X', 'tingkat' => 'X']);
        $kelasXI = Kelas::create(['nama_kelas' => 'XI', 'tingkat' => 'XI']);
        $kelasXII = Kelas::create(['nama_kelas' => 'XII', 'tingkat' => 'XII']);

        // Sub Kelas
        SubKelas::create(['kelas_id' => $kelasX->id, 'nama_sub_kelas' => 'IPA']);
        SubKelas::create(['kelas_id' => $kelasX->id, 'nama_sub_kelas' => 'IPS']);
        SubKelas::create(['kelas_id' => $kelasXI->id, 'nama_sub_kelas' => 'IPA']);
        SubKelas::create(['kelas_id' => $kelasXI->id, 'nama_sub_kelas' => 'IPS']);
        SubKelas::create(['kelas_id' => $kelasXII->id, 'nama_sub_kelas' => 'IPA']);
        SubKelas::create(['kelas_id' => $kelasXII->id, 'nama_sub_kelas' => 'IPS']);

        // Mata Pelajaran
        MataPelajaran::create(['kode_mapel' => 'MTK', 'nama_mapel' => 'Matematika']);
        MataPelajaran::create(['kode_mapel' => 'BIN', 'nama_mapel' => 'Bahasa Indonesia']);
        MataPelajaran::create(['kode_mapel' => 'BIG', 'nama_mapel' => 'Bahasa Inggris']);
        MataPelajaran::create(['kode_mapel' => 'FIS', 'nama_mapel' => 'Fisika']);
        MataPelajaran::create(['kode_mapel' => 'KIM', 'nama_mapel' => 'Kimia']);
        MataPelajaran::create(['kode_mapel' => 'BIO', 'nama_mapel' => 'Biologi']);
        MataPelajaran::create(['kode_mapel' => 'EKO', 'nama_mapel' => 'Ekonomi']);
        MataPelajaran::create(['kode_mapel' => 'SOS', 'nama_mapel' => 'Sosiologi']);
        MataPelajaran::create(['kode_mapel' => 'SEJ', 'nama_mapel' => 'Sejarah']);
        MataPelajaran::create(['kode_mapel' => 'GEO', 'nama_mapel' => 'Geografi']);
    }
}
