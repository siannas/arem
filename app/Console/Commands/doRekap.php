<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Formulir;
use App\Pertanyaan;
use App\Jawaban;
use App\Rekap;
use App\User;
use Illuminate\Support\Facades\Storage;

class doRekap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doRekap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'untuk melakukan rekap pada jawaban yg telah divalidasi';

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
        foreach (Jawaban::where('validasi', 1)->where('status_rekap', 0)->cursor() as $j) {
            $jawaban_id = $j->id;
            $jawaban_raw = Jawaban::findOrFail($jawaban_id);
            $formulir = Formulir::findOrFail($jawaban_raw->id_formulir);
            $pertanyaan = Pertanyaan::where('id_formulir', $jawaban_raw->id_formulir)->get();

            $jawaban = json_decode($jawaban_raw->json, true);

            $rekap = Rekap::where('id_formulir', $jawaban_raw->id_formulir)->where('id_sekolah', $jawaban_raw->id_user_sekolah)->first();

            if(!$rekap){
                $rekap = new Rekap([
                    'id_formulir' => $jawaban_raw->id_formulir,
                    'id_sekolah' => $jawaban_raw->id_user_sekolah,
                    'json' => null
                ]);

                //inisialisasi json rekap jika belum ada
                $allRes = [];
                foreach( $pertanyaan as $p){
                    $res = (object) [];
                    $json = json_decode($p->json);
                    $res->judul = $p->judul;
                    $res->pertanyaan = $json->pertanyaan;
                    foreach ($json->pertanyaan as $pp) {
                        if($pp->tipe === 3){    //pertanyaan pilgan dengan tambahan jawaban
                            $opsi = [];
                            $tambahan = [];
                            foreach ($pp->opsi as $o) {
                                if(is_object($o)){
                                    $opsi[$o->{'0'}] = 0;
                                    $tambahan[$o->{'0'}] = $o->{'if-selected'};
                                    $tambahan[$o->{'0'}]->jawaban = null;
                                }else{
                                    $opsi[$o] = 0;
                                }
                            }
                            $pp->opsi = (object) $opsi;
                            $pp->tambahan = $tambahan;
                        }else if($pp->tipe === 1){ //pertanyaan tipe 1 jaga-jaga
                            $opsi = [];
                            foreach ($pp->opsi as $o) {
                                $opsi[$o] = 0;
                            }
                            $pp->opsi = (object) $opsi;
                        }else if($pp->tipe === 2 || $pp->tipe === 4){ //pertanyaan isian atau upload gambar
                            $pp->jawaban = null;
                        }
                    }
                    $allRes[] = $res;
                }
            }else{
                $allRes = json_decode($rekap->json, false);
            }

            foreach( $allRes as $a){
                foreach ($a->pertanyaan as $aa) {
                    switch ($aa->tipe) {
                        case 3:
                            $key = $jawaban[$aa->id];
                            $aa->opsi->{$key}+=1;
                            $aa->tambahan = (object) $aa->tambahan;
                            try {
                                if($aa->tambahan->{$key}){
                                    $id_ = $aa->tambahan->{$key}->id;
                                    //append to file
                                    $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$id_.".html";
                                    Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$id_].'" disabled></div>');
                                    $aa->tambahan->{$key}->jawaban = $formulir->id."_".$id_.".html";
                                }
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                            break;
                        case 1:
                            $key = $jawaban[$aa->id];
                            $aa->opsi->{$key}+=1;
                        case 2:
                            $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
                            Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$aa->id].'" disabled></div>');
                            $aa->jawaban = $formulir->id."_".$aa->id.".html";
                            break;
                        case 4:
                            $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
                            preg_match('/[^\/]+$/', $jawaban[$aa->id], $matches);
                            $judulGambar = $matches[0];
                            Storage::append($namafile, '<div class="form-group"><a href="'.$jawaban[$aa->id].'" target="_blank" ><input type="text" class="form-control" value="Link: '.$judulGambar.'" disabled></a></div>');
                            $aa->jawaban = $formulir->id."_".$aa->id.".html";
                            break;
                    }
                }
            }

            $rekap->fill([ 'json'=>json_encode($allRes) ]);
            $jawaban_raw->fill(['status_rekap'=>1]);
            $jawaban_raw->save();
            $rekap->save();
        }
    }
}
