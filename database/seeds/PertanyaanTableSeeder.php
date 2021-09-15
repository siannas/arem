<?php

use Illuminate\Database\Seeder;

class PertanyaanTableSeeder extends Seeder
{
    private $sub_pertanyaan_1 = [
        [
            "id" => "_309ads",
            "tipe" => 1,
            "pertanyaan" => "Rambut",
            "opsi" => ["Sehat", "Tidak Sehat"],
            "gambar-petunjuk" => null,
            "required" => TRUE
        ],
        [
            "id" => "_387s9a",
            "tipe" => 1,
            "pertanyaan" => "Kuku",
            "opsi" => ["Sehat", "Tidak Sehat"],
            "gambar-petunjuk" => null,
            "required" => TRUE
        ],
        [
            "id" => "3jshfvd",
            "tipe" => 2,
            "pertanyaan" => "Tekanan darah",
            "suffix" => "mm Hg",
            "gambar-petunjuk" => null,
            "required" => true
        ]
    ];

    private $sub_pertanyaan_2 = [
        
        [
            "id" => "oids93q",
            "tipe" => 1,
            "pertanyaan" => "Sarapan",
            "opsi" => ["Selalu", "Kadang", "Tidak Pernah"],
            "gambar-petunjuk" => null,
            "required" => TRUE
        ],
        [
            "id" => "98s7dfy",
            "tipe" => 3,
            "pertanyaan" => "Alergi",
            "opsi" => [
                "Tidak", 
                [
                    "Ya",
                    "if-selected" => [
                            "id" =>  "98s7dfy_1",
                            "tipe" =>  2,
                            "pertanyaan" =>  "Sebutkan",
                            "suffix" =>  null,
                            "required" =>  true
                    ]
                ],
                [
                    "Coba",
                    "if-selected" => [
                        "id" => "98s7dfy_2",
                        "tipe" => 1,
                        "pertanyaan" => "Rambut",
                        "opsi" => [
                                "Sehat", 
                                "Tidak Sehat"
                        ],
                        "required" => true
                    ]
                ]
            ],
            "gambar-petunjuk" => null,
            "required" => true
        ],
        [
            "id" => "liushfd",
            "tipe" => 4,
            "pertanyaan" => "Foto Gigi Bagian Depan",
            "gambar-petunjuk" => "URL",
            "required" => true
        ],
        [
            "id" => " vilkduc",
            "tipe" => 4,
            "pertanyaan" => "Foto Gigi Bagian Dalam",
            "gambar-petunjuk" => "URL",
            "required" => true
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formulir = App\Formulir::create([
            'status' => 0,
            'kelas' => '1,2,3,4,5,6',
            'tahun_ajaran' => '2021-2022',
        ]);

        $formulir->save();

        $formulir = App\Formulir::find(1);

        $pertanyaan1 = App\Pertanyaan::create([
            'json' => json_encode(
                [
                    "judul"=> "A. Riwayat Kesehatan Anak",
                    "gambar-petunjuk" => null,
                    "pertanyaan" => $this->sub_pertanyaan_1
                ]
            )
        ]);

        $pertanyaan2 = App\Pertanyaan::create([
            'json' => json_encode(
                [
                    "judul"=> "B. Kesehatan Intelegensia",
                    "gambar-petunjuk" => null,
                    "pertanyaan" => $this->sub_pertanyaan_2
                ]
            )
        ]);

        $pertanyaan_tes = new App\Pertanyaan([
            'json' => json_encode(
                [
                    "judul"=> "A. Riwayat Kesehatan Anak",
                    "gambar-petunjuk" => null,
                    "pertanyaan" => $this->sub_pertanyaan_1
                ]
            )
        ]);
        
        $formulir->pertanyaan()->saveMany([$pertanyaan1, $pertanyaan2]);
    }
}
