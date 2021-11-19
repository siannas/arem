<?php

use Illuminate\Database\Seeder;

class AdditionalUsersTableSeeder extends Seeder
{
    // nama, kode, id puskesmas, id kecamatan
    private $kelurahan = [
        ['KELURAHAN DARMO','3578041005',61,31],
        ['KELURAHAN JAGIR','3578041002',61,31],
        ['KELURAHAN NGAGEL','3578041003',61,31],
        ['KELURAHAN NGAGEL REJO','3578041004',61,31],
        ['KELURAHAN SAWUNGGALING','3578041006',61,31],
        ['KELURAHAN WONOKROMO','3578041001',61,31],
        ['KELURAHAN BENDUL MERISI','3578021002',58,30],
        ['KELURAHAN JEMUR WONOSARI','3578021004',58,30],
        ['KELURAHAN MARGOREJO','3578021003',58,30],
        ['KELURAHAN SIDOSERMO','3578021001',58,30],
        ['KELURAHAN SIWALANKERTO','3578021005',58,30],
        ['KELURAHAN BABATAN','3578201003',56,29],
        ['KELURAHAN BALAS KLUMPRIK','3578201004',56,29],
        ['KELURAHAN JAJAR TUNGGAL','3578201002',56,29],
        ['KELURAHAN WIYUNG','3578201001',56,29],
        ['KELURAHAN KENDANGSARI','3578241002',55,28],
        ['KELURAHAN KUTISARI','3578241001',55,28],
        ['KELURAHAN PANJANG JIWO','3578241004',55,28],
        ['KELURAHAN TENGILIS MEJOYO','3578241003',55,28],
        ['KELURAHAN DR. SOETOMO','3578051002',53,27],
        ['KELURAHAN KEDUNGDORO','3578051003',53,27],
        ['KELURAHAN KEPUTRAN','3578051004',53,27],
        ['KELURAHAN TEGALSARI','3578051001',53,27],
        ['KELURAHAN WONOREJO','3578051005',53,27],
        ['KELURAHAN BALONGSARI','3578141007',51,26],
        ['KELURAHAN BANJAR SUGIAN','3578141012',51,26],
        ['KELURAHAN KARANG POH (GADEL, TUBANAN)','3578141006',51,26],
        ['KELURAHAN MANUKAN KULON','3578141009',51,26],
        ['KELURAHAN MANUKAN WETAN (BIBIS, BUNTARAN)','3578141011',51,26],
        ['KELURAHAN TANDES (KIDUL, LOR, GEDANG ASIN)','3578141002',51,26],
        ['KELURAHAN DUKUH SETRO','3578101008',48,25],
        ['KELURAHAN GADING','3578101003',48,25],
        ['KELURAHAN KAPAS MADYA BARU','3578101007',48,25],
        ['KELURAHAN PACARKELING','3578101006',48,25],
        ['KELURAHAN PACARKEMBANG','3578101004',48,25],
        ['KELURAHAN PLOSO','3578101002',48,25],
        ['KELURAHAN RANGKAH','3578101005',48,25],
        ['KELURAHAN TAMBAKSARI','3578101001',48,25],
        ['KELURAHAN PUTAT GEDE','3578271004',43,23],
        // ['KELURAHAN SIMOMULYO','3578271005',43,23],
        ['KELURAHAN SIMOMULYO BARU','3578271006',43,23],
        ['KELURAHAN SONOKWIJENAN','3578271003',43,23],
        ['KELURAHAN SUKOMANUNGGAL','3578271001',43,23],
        ['KELURAHAN TANJUNGSARI','3578271002',43,23],
        ['KELURAHAN GEBANG PUTIH','3578091002',45,24],
        ['KELURAHAN KEPUTIH','3578091001',45,24],
        ['KELURAHAN KLAMPIS NGASEM','3578091003',45,24],
        ['KELURAHAN MEDOKAN SEMAMPIR','3578091007',45,24],
        ['KELURAHAN MENUR PUMPUNGAN','3578091004',45,24],
        ['KELURAHAN NGINDEN JANGKUNGAN','3578091005',45,24],
        ['KELURAHAN SEMOLOWARU','3578091006',45,24],
        ['KELURAHAN KAPASAN','3578111002',41,22],
        ['KELURAHAN SIDODADI','3578111003',41,22],
        ['KELURAHAN SIMOKERTO','3578111001',41,22],
        ['KELURAHAN SIMOLAWANG','3578111004',41,22],
        ['KELURAHAN TAMBAKREJO','3578111005',41,22],
        ['KELURAHAN AMPEL','3578161001',37,21],
        ['KELURAHAN PEGIRIKAN','3578161002',37,21],
        ['KELURAHAN SIDOTOPO','3578161005',37,21],
        ['KELURAHAN UJUNG','3578161004',37,21],
        ['KELURAHAN WONOKUSUMO','3578161003',37,21],
        ['KELURAHAN BANYU URIP','3578061003',34,20],
        ['KELURAHAN KUPANG KRAJAN','3578061005',34,20],
        ['KELURAHAN PAKIS','3578061006',34,20],
        ['KELURAHAN PETEMON','3578061001',34,20],
        ['KELURAHAN PUTAT JAYA','3578061004',34,20],
        ['KELURAHAN SAWAHAN','3578061002',34,20],
        ['KELURAHAN BRINGIN','3578311003',32,19],
        ['KELURAHAN LONTAR','3578311004',32,19],
        ['KELURAHAN MADE','3578311002',32,19],
        ['KELURAHAN SAMBIKEREP','3578311001',32,19],
        ['KELURAHAN KALIRUNGKUT','3578031001',30,18],
        ['KELURAHAN KEDUNG BARUK','3578031003',30,18],
        ['KELURAHAN MEDOKAN AYU','3578031006',30,18],
        ['KELURAHAN PENJARINGANSARI','3578031004',30,18],
        ['KELURAHAN RUNGKUT KIDUL','3578031002',30,18],
        ['KELURAHAN WONOREJO','3578031005',30,18],
        ['KELURAHAN BABAT JERAWAT','3578301002',29,17],
        ['KELURAHAN BENOWO','3578301005',29,17],
        ['KELURAHAN PAKAL','3578301001',29,17],
        ['KELURAHAN SUMBER REJO','3578301004',29,17],
        ['KELURAHAN BONGKARAN','3578121001',28,16],
        ['KELURAHAN KREMBANGAN UTARA','3578121003',28,16],
        ['KELURAHAN NYAMPLUNGAN','3578121002',28,16],
        ['KELURAHAN PERAK TIMUR','3578121004',28,16],
        ['KELURAHAN PERAK UTARA','3578121005',28,16],
        ['KELURAHAN DUKUH SUTOREJO','3578261005',26,15],
        ['KELURAHAN KALIJUDAN','3578261006',26,15],
        ['KELURAHAN KALISARI','3578261004',26,15],
        ['KELURAHAN KEJAWAAN PUTIH TAMBAK','3578261003',26,15],
        ['KELURAHAN MANYAR SABRANGAN','3578261002',26,15],
        ['KELURAHAN MULYOREJO','3578261001',26,15],
        ['KELURAHAN BANGKINGAN','3578181001',23,14],
        ['KELURAHAN JERUK','3578181002',23,14],
        ['KELURAHAN LAKARSANTRI','3578181003',23,14],
        ['KELURAHAN LIDAH KULON','3578181004',23,14],
        ['KELURAHAN LIDAH WETAN','3578181005',23,14],
        ['KELURAHAN SUMUR WELUT','3578181006',23,14],
        ['KELURAHAN DUPAK','3578151004',20,13],
        ['KELURAHAN KEMAYORAN','3578151002',20,13],
        ['KELURAHAN KREMBANGAN SELATAN','3578151001',20,13],
        ['KELURAHAN MOROKREMBANGAN','3578151005',20,13],
        ['KELURAHAN PERAK BARAT','3578151003',20,13],
        ['KELURAHAN BULAK BANTENG','3578171003',16,12],
        ['KELURAHAN SIDOTOPO WETAN','3578171002',16,12],
        ['KELURAHAN TAMBAK WEDI','3578171004',16,12],
        ['KELURAHAN TANAH KALI KEDINDING','3578171001',16,12],
        ['KELURAHAN KARANGPILANG','3578011001',15,11],
        ['KELURAHAN KEBRAON','3578011002',15,11],
        ['KELURAHAN KEDURUS','3578011003',15,11],
        ['KELURAHAN WARUGUNUNG','3578011004',15,11],
        ['KELURAHAN JAMBANGAN','3578231001',14,10],
        ['KELURAHAN KARAH','3578231002',14,10],
        ['KELURAHAN KEBONSARI','3578231003',14,10],
        ['KELURAHAN PAGESANGAN','3578231004',14,10],
        ['KELURAHAN GUNUNG ANYAR','3578251001',13,9],
        ['KELURAHAN GUNUNG ANYAR TAMBAK','3578251004',13,9],
        ['KELURAHAN RUNGKUT MENANGGAL','3578251003',13,9],
        ['KELURAHAN RUNGKUT TENGAH','3578251002',13,9],
        ['KELURAHAN AIRLANGGA','3578081003',11,8],
        ['KELURAHAN BARATAJAYA','3578081005',11,8],
        ['KELURAHAN GUBENG','3578081001',11,8],
        ['KELURAHAN KERTAJAYA','3578081004',11,8],
        ['KELURAHAN MOJO','3578081002',11,8],
        ['KELURAHAN PUCANG SEWU','3578081006',11,8],
        ['KELURAHAN EMBONG KALIASIN','3578071001',9,7],
        ['KELURAHAN GENTENG','3578071002',9,7],
        ['KELURAHAN KAPASARI','3578071003',9,7],
        ['KELURAHAN KETABANG','3578071004',9,7],
        ['KELURAHAN PENELEH','3578071005',9,7],
        ['KELURAHAN DUKUH MENANGGAL','3578221003',8,6],
        ['KELURAHAN GAYUNGAN','3578221001',8,6],
        ['KELURAHAN KETINTANG','3578221004',8,6],
        ['KELURAHAN MENANGGAL','3578221002',8,6],
        ['KELURAHAN DUKUH KUPANG','3578211002',6,5],
        ['KELURAHAN DUKUH PAKIS','3578211001',6,5],
        ['KELURAHAN GUNUNG SARI','3578211003',6,5],
        ['KELURAHAN PRADAH KALI KENDAL','3578211004',6,5],
        ['KELURAHAN BULAK','3578291004',5,4],
        ['KELURAHAN KEDUNG COWEK','3578291001',5,4],
        ['KELURAHAN KENJERAN','3578291003',5,4],
        ['KELURAHAN SUKOLILO BARU','3578291005',5,4],
        ['KELURAHAN ALUN-ALUN CONTONG','3578131001',3,3],
        ['KELURAHAN BUBUTAN','3578131002',3,3],
        ['KELURAHAN GUNDIH','3578131003',3,3],
        ['KELURAHAN JEPARA','3578131004',3,3],
        ['KELURAHAN TEMBOK DUKUH','3578131005',3,3],
        ['KELURAHAN KANDANGAN','3578191001',2,2],
        ['KELURAHAN ROMOKALISARI','3578191005',2,2],
        ['KELURAHAN SEMEMI','3578191003',2,2],
        ['KELURAHAN TAMBAK OSOWILANGUN','3578191004',2,2],
        ['KELURAHAN ASEM ROWO','3578281001',1,1],
        ['KELURAHAN GENTING KALIANAK','3578281002',1,1],
        ['KELURAHAN TAMBAK SARIOSO','3578281005',1,1]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->kelurahan as $k => $val) {
            $s = factory(App\User::class)->create([
                'nama' => $val[0],
                'username' => $val[1],
                'kelas' => null,
                'id_role' => 3,
            ]);
            $s->parents()->attach($val[2] + 32); //attach ke puskesmas
            $s->parents()->attach($val[3] + 1); //attach ke kecamatan
        }

        // 1033289 - puskesmas kalirungkut
        // 357803 - kecamatan rungkut
        $sekolahs=[
            // 3578031001 - kelurahan kalirungkut
            [['20532992','SD ISLAM TARBIYATUL ATHFAL',1],
            ['20533574','SD NEGERI KENDANGSARI III',1],
            ['69896629','SD SINAR MULIA INDONESIA',1],
            ['20532811','SD YAMASTHO',1],
            ['20533424','SD NEGERI KALI RUNGKUT',1],
            ['20533438','SD NEGERI KALIRUNGKUT',1],
            ['20533565','SD NEGERI KENDANGSARI',1],
            ['20532495','SMP TARUNA SURABAYA',7],
            ['20532597','SMP TENGGILIS JAYA',7],
            ['20532556','SMP NEGERI 17 SURABAYA',7],
            ['20532238','SMAN 14 SURABAYA',10],
            ['20532124','SMAS TARUNA SURABAYA',10]],
            // 3578031001 - kelurahan kalirungkut
            [['20533053','SD INTAN PERMATA HATI',1],
            ['20533050','SD ISLAM JIWA NALA',1],
            ['20532812','SD ISLAM YAMASSA',1],
            ['20533462','SD NEGERI KEDUNG BARUK',1],
            ['20532214','SMKS PERDANA SURABAYA',10],
            ['20532799','SMP ISLAM JIWA NALA',7],
            ['20532540','SMP NEGERI 23 SURABAYA',7],
            ['20532624','SMP YAMASSA',7]],
            // 3578031006 - kelurahan medokan ayu
            [['60720941','MIN 1 KOTA SURABAYA',1],
            ['20583877','MTSN 3 KOTA SURABAYA',7],
            ['69984653','SD JUARA',1],
            ['20571670','SD MENTARI KASIH',1],
            ['20533195','SD NEGERI MEDOKAN AYU I',1],
            ['20533196','SD NEGERI MEDOKAN AYU II',1],
            ['69985994','SD NURUL FAIZAH',1]],
            // 3578031002 - kelurahan rungkut kidul
            [['20532994','SD ISLAM WACHID HASYIM',7],
            ['20533410','SD NEGERI RUNGKUT KIDUL I',7],
            ['20533422','SD NEGERI RUNGKUT KIDUL II',7],
            ['70008708','SMAK HARVEST CENTER SCHOOL',10],
            ['20532217','SMAN 17 SURABAYA',10],
            ['20532701','SMP AL - WACHID',7],
            ['20532577','SMP NEGERI 35 SURABAYA',7],
            ['70003145','SMPTK Harvest Center School',7]],
            // 3578031005 - kelurahan wonorejo
            [['20580755','MAN KOTA SURABAYA',10],
            ['20584173','MA NURUL KHOIR WONOREJO',10],
            ['69927720','MIS Muhammadiyah 27 Surabaya',1],
            ['20583880','MTS NURUL KHOIR',7],
            ['69978297','SD KHADIJAH WONOREJO',1],
            ['20532423','SD NEGERI WONOREJO',1],
            ['20573205','SMAS INTAN PERMATA HATI',10],
            ['20571625','SMP KRISTEN INTAN PERMATA HATI SURABAYA',7],
            ['20531931','SD ISLAM AL KHOIRIYYAH',1]]
        ];

        $datas=[
            ['3578031001','1033289','357803'],
            ['3578031003','1033289','357803'],
            ['3578031006','1033289','357803'],
            ['3578031002','1033289','357803'],
            ['3578031005','1033289','357803'],
            
        ];
        foreach ($sekolahs as $i=>$ss) {
            $kelurahan = \App\User::where('username',$datas[$i][0])->select('id')->first();
            $puskesmas = \App\User::where('username',$datas[$i][1])->select('id')->first();
            $kecamatan = \App\User::where('username',$datas[$i][2])->select('id')->first();
            foreach ($ss as $k => $val) {
                $s = factory(App\User::class)->create([
                    'nama' => $val[1],
                    'username' => $val[0],
                    'kelas' => $val[2],
                    'id_role' => 2,
                ]);
                
                $users = factory(App\User::class, 200)->create();
                $s->users()->attach($users);  //assign siswa ke sekolah

                $kelurahan->users()->attach($users); //attach ke kelurahan
                $kelurahan->users()->attach($s);

                $puskesmas->users()->attach($users); //attach ke puskesmas
                $puskesmas->users()->attach($s);

                $kecamatan->users()->attach($users); //attach ke kecamatan
                $kecamatan->users()->attach($s);
            }
        }

    }
}
