<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\UserPivot;
use App\Formulir;
use App\Jawaban;
use App\Metadata;

class updateDashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateDashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // Get Data Status tiap Sekolah
        $siswaTerdaftar = 0;
        $form_aktif = Formulir::select('id')->where('status', 1)->get();
        $sekolah = User::select('id')->where('id_role', 2)->get();
        foreach($sekolah as $unit){
            $jumlah_siswa = UserPivot::where('id_user', $unit->id)->count();
            $siswaTerdaftar += $jumlah_siswa;
            $siswa = UserPivot::select('id_child')->where('id_user', $unit->id)->get();
            $blmValidSek = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah', 0)->where('validasi_puskesmas',0)->count();
            $ValidSek = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah', 1)->where('validasi_puskesmas', 0)->count();
            $ValidPus = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah', 1)->where('validasi_puskesmas', 1)->count();
            $dirujuk = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah',1)->where('validasi_puskesmas', -1)->count();
            $sdhDirujuk = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah',1)->where('validasi_puskesmas', 2)->count();
            $blmIsi = $jumlah_siswa-$blmValidSek-$ValidSek-$ValidPus-$dirujuk-$sdhDirujuk;            

            $meta_baru = Metadata::where('key', 'jumlah_status_'.$unit->id)->first();
            if(isset($meta_baru)){
                $meta_baru->value = $unit->id.','.$jumlah_siswa.','.$blmIsi.','.$blmValidSek.','.$ValidSek.','.$ValidPus.','.$dirujuk.','.$sdhDirujuk;
                $meta_baru->save();
            } else{
                $meta_baru = new Metadata();
                $meta_baru->key = 'jumlah_status_'.$unit->id;
                $meta_baru->value = $unit->id.','.$jumlah_siswa.','.$blmIsi.','.$blmValidSek.','.$ValidSek.','.$ValidPus.','.$dirujuk.','.$sdhDirujuk;
                $meta_baru->save();
            }
            
        }
        
        // Hitung Jumlah Semua Siswa (Terdaftar Sekolah maupun Tidak)
        $meta_baru = Metadata::where('key', 'jumlah_siswa')->first();
        $siswaSemua = User::where('id_role', 1)->count();
        $meta_baru->value = $siswaSemua.','.$siswaTerdaftar;
        $meta_baru->save();

        // Timestamp Last Update
        $meta_baru = Metadata::where('key','last_update')->first();
        date_default_timezone_set("Asia/Jakarta");
        $meta_baru->value = date("d-m-Y H:i:s");
        $meta_baru->save();
    }
}
