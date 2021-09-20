<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $kecamatan = [
        ['KECAMATAN ASEMROWO', '357828'],
        ['KECAMATAN BENOWO', '357819'],
        ['KECAMATAN BUBUTAN', '357813'],
        ['KECAMATAN BULAK', '357829'],
        ['KECAMATAN DUKUH PAKIS', '357821'],
        ['KECAMATAN GAYUNGAN', '357822'],
        ['KECAMATAN GENTENG', '357807'],
        ['KECAMATAN GUBENG', '357808'],
        ['KECAMATAN GUNUNG ANYAR', '357825'],
        ['KECAMATAN JAMBANGAN', '357823'],
        ['KECAMATAN KARANG PILANG', '357801'],
        ['KECAMATAN KENJERAN', '357817'],
        ['KECAMATAN KREMBANGAN', '357815'],
        ['KECAMATAN LAKARSANTRI', '357818'],
        ['KECAMATAN MULYOREJO', '357826'],
        ['KECAMATAN PABEAN CANTIAN', '357812'],
        ['KECAMATAN PAKAL', '357830'],
        ['KECAMATAN RUNGKUT', '357803'],
        ['KECAMATAN SAMBIKEREP', '357831'],
        ['KECAMATAN SAWAHAN', '357806'],
        ['KECAMATAN SEMAMPIR', '357816'],
        ['KECAMATAN SIMOKERTO', '357811'],
        ['KECAMATAN SUKOMANUNGGAL', '357827'],
        ['KECAMATAN SUKOLILO', '357809'],
        ['KECAMATAN TAMBAKSARI', '357810'],
        ['KECAMATAN TANDES', '357814'],
        ['KECAMATAN TEGALSARI', '357805'],
        ['KECAMATAN TENGGILIS MEJOYO', '357824'],
        ['KECAMATAN WIYUNG', '357820'],
        ['KECAMATAN WONOCOLO', '357802'],
        ['KECAMATAN WONOKROMO', '357804'],
    ];

    private $puskesmas = [
        ['PUSKESMAS ASEMROWO SURABAYA', '1033340', 1 ],
        ['PUSKESMAS SEMEMI SURABAYA', '1033341', 2 ],
        ['PUSKESMAS GUNDIH SURABAYA', '1033336', 3 ],
        ['PUSKESMAS TEMBOK DUKUH SURABAYA', '1033335', 3 ],
        ['PUSKESMAS KENJERAN SURABAYA', '1033326', 4 ],
        ['PUSKESMAS DUKUH KUPANG SURABAYA', '1033301', 5 ],
        ['PUSKESMAS PAKIS SURABAYA', '1033300', 5 ],
        ['PUSKESMAS GAYUNGAN SURABAYA', '1033282', 6 ],
        ['PUSKESMAS KETABANG SURABAYA', '1033320', 7 ],
        ['PUSKESMAS PENELEH SURABAYA', '1033319', 7 ],
        ['PUSKESMAS MOJO SURABAYA', '1033296', 8 ],
        ['PUSKESMAS PUCANG SEWU SURABAYA', '1033295', 8 ],
        ['PUSKESMAS GUNUNG ANYAR SURABAYA', '1033287', 9 ],
        ['PUSKESMAS KEBONSARI SURABAYA', '1033281', 10 ],
        ['PUSKESMAS KEDURUS SURABAYA', '1033280', 11 ],
        ['PUSKESMAS BULAK BANTENG SURABAYA', '1033328', 12 ],
        ['PUSKESMAS SIDOTOPO WETAN SURABAYA', '1033325', 12 ],
        ['PUSKESMAS TAMBAK WEDI SURABAYA', '1033327', 12 ],
        ['PUSKESMAS TANAH KALIKEDINDING SURABAYA', '1033324', 12 ],
        ['PUSKESMAS DUPAK SURABAYA', '1033338', 13 ],
        ['PUSKESMAS KREMBANGAN SELATAN SURABAYA', '1033337', 13 ],
        ['PUSKESMAS MOROKREMBANGAN SURABAYA', '1033339', 13 ],
        ['PUSKESMAS BANGKINGAN SURABAYA', '1033306', 14 ],
        ['PUSKESMAS JERUK SURABAYA', '1033304', 14 ],
        ['PUSKESMAS LIDAH KULON SURABAYA', '1033305', 14 ],
        ['PUSKESMAS KALIJUDAN SURABAYA', '1033294', 15 ],
        ['PUSKESMAS MULYOREJO SURABAYA', '1033293', 15 ],
        ['PUSKESMAS PERAK TIMUR SURABAYA', '1033334', 16 ],
        ['PUSKESMAS BENOWO SURABAYA', '1033308', 17 ],
        ['PUSKESMAS KALIRUNGKUT SURABAYA', '1033289', 18 ],
        ['PUSKESMAS MEDOKAN AYU SURABAYA', '1033288', 18 ],
        ['PUSKESMAS LONTAR SURABAYA', '1033307', 19 ],
        ['PUSKESMAS MADE SURABAYA', '1033309', 19 ],
        ['PUSKESMAS BANYU URIP SURABAYA', '1033314', 20 ],
        ['PUSKESMAS PUTAT JAYA SURABAYA', '1033316', 20 ],
        ['PUSKESMAS SAWAHAN SURABAYA', '1033315', 20 ],
        ['PUSKESMAS PEGIRIAN SURABAYA', '1033332', 21 ],
        ['PUSKESMAS SAWAH PULO SURABAYA', '1033580', 21 ],
        ['PUSKESMAS SIDOTOPO SURABAYA', '1033331', 21 ],
        ['PUSKESMAS WONOKUSUMO SURABAYA', '1033333', 21 ],
        ['PUSKESMAS SIMOLAWANG SURABAYA', '1033330', 22 ],
        ['PUSKESMAS TAMBAKREJO SURABAYA', '1033329', 22 ],
        ['PUSKESMAS SIMOMULYO SURABAYA', '1033313', 23 ],
        ['PUSKESMAS TANJUNGSARI SURABAYA', '1033312', 23 ],
        ['PUSKESMAS KEPUTIH SURABAYA', '1033292', 24 ],
        ['PUSKESMAS KLAMPIS NGASEM SURABAYA', '1033291', 24 ],
        ['PUSKESMAS MENUR SURABAYA', '1033290', 24 ],
        ['PUSKESMAS GADING SURABAYA', '1033323', 25 ],
        ['PUSKESMAS PACARKELING SURABAYA', '1033322', 25 ],
        ['PUSKESMAS RANGKAH SURABAYA', '1033321', 25 ],
        ['PUSKESMAS BALONGSARI SURABAYA', '1033311', 26 ],
        ['PUSKESMAS MANUKAN KULON SURABAYA', '1033310', 26 ],
        ['PUSKESMAS DR. SOETOMO SURABAYA', '1033318', 27 ],
        ['PUSKESMAS KEDUNGDORO SURABAYA', '1033317', 27 ],
        ['PUSKESMAS TENGGILIS SURABAYA', '1033286', 28 ],
        ['PUSKESMAS BALAS KLUMPRIK SURABAYA', '1033303', 29 ],
        ['PUSKESMAS WIYUNG SURABAYA', '1033302', 29 ],
        ['PUSKESMAS JEMURSARI SURABAYA', '1033283', 30 ],
        ['PUSKESMAS SIDOSERMO SURABAYA', '1033284', 30 ],
        ['PUSKESMAS SIWALANKERTO SURABAYA', '1033285', 30 ],
        ['PUSKESMAS JAGIR SURABAYA', '1033297', 31 ],
        ['PUSKESMAS NGAGELREJO SURABAYA', '1033299', 31 ],
        ['PUSKESMAS WONOKROMO SURABAYA', '1033298', 31 ],
    ];

    // nama, kode, id puskesmas
    private $kelurahan = [
        ['KELURAHAN SIMOMULYO SURABAYA', '3578271005', 43],
    ];

    // nama, kode, id kelurahan
    private $sekolah = [
        ['SD NEGERI SIMOMULYO I SURABAYA', '20532331', 1],
        ['SMP NEGERI 25 SURABAYA', '20532542', 1],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 0;

        $dinas = $users = factory(App\User::class)->create([
            'nama' => 'DINAS KESEHATAN KOTA SURABAYA',
            'username' => 'dinkes_sby',
            'kelas' => null,
            'id_role' => 6,
        ]);
        $count = 1;

        $kecamatans_ = [];
        foreach ($this->kecamatan as $k => $val) {
            $s = factory(App\User::class)->create([
                'nama' => $val[0],
                'username' => $val[1],
                'kelas' => null,
                'id_role' => 5,
            ]);
            $s->parents()->attach($dinas);
            $kecamatans_[] = $s;
        }

        $puskesmass_ = [];
        foreach ($this->puskesmas as $k => $val) {
            $s = factory(App\User::class)->create([
                'nama' => $val[0],
                'username' => $val[1],
                'kelas' => null,
                'id_role' => 4,
            ]);
            $s->parents()->attach($val[2] + $count);
            $puskesmass_[] = $s;
        }
        $count += count($this->kecamatan);

        $kelurahans_ = [];
        foreach ($this->kelurahan as $k => $val) {
            $s = factory(App\User::class)->create([
                'nama' => $val[0],
                'username' => $val[1],
                'kelas' => null,
                'id_role' => 3,
            ]);
            $s->parents()->attach($val[2] + $count);
            $kelurahans_[] = $s;
        }
        $count += count($this->puskesmas);

        foreach ($this->sekolah as $k => $val) {
            $s = factory(App\User::class)->create([
                'nama' => $val[0],
                'username' => $val[1],
                'kelas' => null,
                'id_role' => 2,
            ]);

            $s->parents()->attach($val[2] + $count);
            $users = factory(App\User::class, 10)->create();

            $s->users()->attach($users);
            $kelurahans_[$val[2]-1]->users()->attach($users);

            $id_puskesmas = $this->kelurahan[$val[2]-1][2];
            $puskesmass_[$id_puskesmas-1]->users()->attach($users);
            $puskesmass_[$id_puskesmas-1]->users()->attach($s);

            $id_kecamatan = $this->puskesmas[$id_puskesmas][2];
            $kecamatans_[$id_kecamatan-1]->users()->attach($users);
            $kecamatans_[$id_kecamatan-1]->users()->attach($s);
            $kecamatans_[$id_kecamatan-1]->users()->attach($puskesmass_[$id_puskesmas-1]);
        }
    }
}
