<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;
use Exception;
use Hash;

class importSekolah extends Command
{
    protected $filepath = 'E:\Ivan\Dinkes\Data Pendukung Aplikasi\Kesga Ning Tasiah\template-sekolah.csv';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importsekolah';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fungsi import sekolah';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $profesis = Profesi::all()->keyBy('kode');

        $row = 1;
        if (($handle = fopen($this->filepath, "r")) !== FALSE) {
            $headers = fgetcsv($handle, 1000, ';');

            try {
                DB::beginTransaction();
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $num = count($data);

                    echo "\n$num fields in line $row:\n";

                    $data = array_combine($headers, $data);
    
                    // $profesi = $profesis[$data['kodeprofesi']];
                    
                    // removeNull($data, true);
                    echo $data['namasekolah'].' - '.$data['npsn'];
                    // if(isset($data['idspesialisasi'])){
                    //     $data['spesialisasi'] = Spesialisasi::find($data['idspesialisasi'])->nama;
                    // }

                    // IMPORT USER
                    $user = User::updateOrCreate(
                        [
                            "nama" => $data['namasekolah'],
                            "username" => $data['npsn'],
                        ],
                        [
                            "nama" => $data['namasekolah'],
                            "username" => $data['npsn'],
                            "id_role" => 2,
                            "password" => Hash::make('password'),
                            "kelas" => 7,
                        ]
                    );

                    // IMPORT PIVOT
                    $pivot = DB::insert('insert into user_pivot (id_user, id_child) values (?, ?)', [$data['idkelurahan'], $user->id]);
                    // $pivot = DB::table('user_pivot')->updateOrCreate(
                    //     [
                    //         "id_user" => $data['idkelurahan'],
                    //         "id_child" => $user->id,
                    //     ],
                    //     [
                    //         "id_user" => $data['idkelurahan'],
                    //         "id_child" => $user->id,
                    //     ]
                    // );
    
                    $row++;
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                echo $e->getMessage();
            }
            
            fclose($handle);
        }
    }
}
