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
        // get data setiap sekolah
        $form_aktif = Formulir::select('id')->where('status', 1)->get();
        $sekolah = User::select('id')->where('id_role', 2)->get();
        foreach($sekolah as $unit){
            $jumlah_siswa = UserPivot::where('id_user', $unit->id)->count();
            $siswa = UserPivot::select('id_child')->where('id_user', $unit->id)->get();
            $blmValidSek = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah', 0)->where('validasi_puskesmas',0)->count();
            $ValidSek = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah', 1)->where('validasi_puskesmas', 0)->count();
            $ValidPus = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah', 1)->where('validasi_puskesmas', 1)->count();
            $dirujuk = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah',1)->where('validasi_puskesmas', -1)->count();
            $sdhDirujuk = Jawaban::whereIn('id_formulir', $form_aktif)->whereIn('id_user', $siswa)->where('validasi_sekolah',1)->where('validasi_puskesmas', 2)->count();
            $blmIsi = $jumlah_siswa-$blmValidSek-$ValidSek-$ValidPus-$dirujuk-$sdhDirujuk;            

            $meta_baru = Metadata::where('key', 'jumlah_status_'.$unit->id)->first();
            $meta_baru->value = $unit->id.','.$jumlah_siswa.','.$blmIsi.','.$blmValidSek.','.$ValidSek.','.$ValidPus.','.$dirujuk.','.$sdhDirujuk;
            $meta_baru->save();
        }
        // foreach($sekolah as $unit){
        //     $meta_baru = new Metadata();
        //     $meta_baru->key = 'jumlah_status_'.$unit->id;
        //     $meta_baru->value = '';
        //     $meta_baru->save();
        // }
        
    }
}
