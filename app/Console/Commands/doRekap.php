<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Formulir;
use App\Pertanyaan;
use App\Jawaban;
use App\Rekap;
use App\User;
use App\Metadata;
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

    private function cekSimpulanTipeFormula(&$j, &$s, &$at)
    {
        $vars=[];
        foreach ($s['vars'] as $k => $v) {
            $vars['/{{'.$k.'}}/']=$j[$v];
        }
        $ma = preg_replace(array_keys($vars), array_values($vars), $s['formula']);
        $res=eval('return '.$ma.';');
        foreach ($s['range'] as $v) {
            $compare=explode(',', $v[0]);
            foreach ($compare as $v2) {
                $res2=eval('return '.$ma.$v2.';');
                if ($res2) {
                    return $v[1];
                }
            }
            $at+=1;
        }
        return false;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cnt=1;
        foreach (Jawaban::where([['validasi_sekolah', 1],['validasi_puskesmas','<>', 0]])->where('status_rekap', 0)->cursor() as $j) {
            echo($cnt++);
            echo('|');
            $jawaban_id = $j->id;

            $jawaban_raw = Jawaban::where('id', $jawaban_id)
                ->with([
                    'getSekolah' => function ($query) {
                        $query->select('id', 'kelas');
                    },
                    'getUser' => function ($query) {
                        $query->select('id', 'kelas','nama');
                    },
                    'getUser.profil'
                ])->first();
            
            $id_sekolah=$jawaban_raw->id_user_sekolah;
            $kelas = $jawaban_raw->getUser->kelas;
            // $gender = $jawaban_raw->getUser->profil->gender;
            ////sementara karena belum ada profil
            $gender_arr=['L','P'];
            $gender = $gender_arr[array_rand($gender_arr)];
            
            $sklh_kelas = $jawaban_raw->getSekolah->kelas;

            $formulir = Formulir::findOrFail($jawaban_raw->id_formulir);
            $pertanyaan = Pertanyaan::where('id_formulir', $jawaban_raw->id_formulir)->get();

            $jawaban = json_decode($jawaban_raw->json, true);

            $rekap = Rekap::where('id_formulir', $jawaban_raw->id_formulir)->where('id_sekolah', $jawaban_raw->id_user_sekolah)->first();

            if (!$rekap) {
                $rekap = new Rekap([
                    'id_formulir' => $jawaban_raw->id_formulir,
                    'id_sekolah' => $jawaban_raw->id_user_sekolah,
                    'json' => null,
                    'L'=>0,
                    'P'=>0,
                ]);
            }

            //SIMPULAN
            $is_new = empty($rekap->csv);

            //PRE KOLEKSI JAWABAN UNTUK REKAP
            if ($is_new) {
                $pp=[];
            } else {
                $pp=json_decode($rekap->json,true);
            }
            //End of PRE KOLEKSI JAWABAN UNTUK REKAP
            
            //inisialisasi csv berbentuk array
            if ($is_new) {
                $csv_arr = [];
            } else {
                $csv=explode('\n', $rekap->csv);
                foreach ($csv as $i=>$c) {
                    $csv[$i]=explode(',', $c);
                }
                $csv_arr=$csv[max($kelas-$sklh_kelas, 0) ];
            }

            if($gender === 'P'){
                $add = 1 ;
                $rekap->P+=1;
            }else{
                $add = 0 ;
                $rekap->L+=1;
            }
            

            $s_count = 0;
            $pre_count = 0;
            foreach ($pertanyaan as $k1 => $p) {
                $pre_count = $s_count;
                $simpulan = json_decode($p->json_simpulan, true);

                //cek pada semua simpulan
                foreach ($simpulan as $k2 => $s) {
                    $metaSIndex=FALSE;
                    switch ($s['tipe']) {
                        case 1:
                            $id = $s['id'];
                            if ($is_new) {
                                array_push($csv_arr, 0, 0);
                            } //PUSH UNTUK LAKI, PEREMPUAN

                            if (in_array($jawaban[$id], $s['opsi'])) {
                                $csv_arr[$s_count+$add]+=1;
                                $metaSIndex=$s_count/2;
                            }
                            
                            $s_count+=2;
                            break;
                        case 2:
                            if ($is_new) {
                                array_push($csv_arr, 0, 0);
                            } //PUSH UNTUK LAKI, PEREMPUAN
                            //apabila jawab salah satu dari array ini
                            for ($i=0; $i < count($s['on']); $i++) {
                                $item = $s['on'][$i];
                                $id = $item[0];
                                if ($jawaban[$id] === $item[1]) {
                                    $csv_arr[$s_count+$add]+=1;
                                    $metaSIndex=$s_count/2;
                                    break;
                                }
                            }

                            $s_count+=2;
                            break;
                        case 3:
                            $range = count($s['range']);
                            if ($is_new) {   //PUSH UNTUK LAKI, PEREMPUAN
                                $f = array_fill(0, $range*2, 0);
                                $csv_arr = array_merge($csv_arr, $f);
                            }
                            $at = 0;
                            $field = $this->cekSimpulanTipeFormula($jawaban, $s, $at);
                            if ($field) {
                                //tambah 1 anak pada kolom dengan field ini
                                $csv_arr[$s_count+$add+$at*2]+=1;
                                $metaSIndex=$s_count/2+$at;
                            }
                            $s_count+=($range*2);
                            break;
                    }

                    if($metaSIndex){
                        //assign siswa ke meta dari opsi simpulan
                        $metakey="rekap_{$id_sekolah}_{$p->id_formulir}_{$p->id}_s_{$k2}_{$gender}";
                        Storage::append("rekap/".$metakey.".txt", $jawaban_raw->getUser->nama.",".$jawaban_raw->getUser->id);
                        // $meta = Metadata::where('key',$metakey)->first();
                        // if(Storage::exists("rekap".$metakey.".txt") === FALSE){
                            // $meta = Metadata::make([
                            //     'key'=> $metakey,
                            //     'value'=>$jawaban_raw->getUser->nama.",".$jawaban_raw->getUser->id,
                            // ]);
                        // }
                        // else{
                            // $meta->value.="\n".$jawaban_raw->getUser->nama.",".$jawaban_raw->getUser->id;
                        // }
                        // $meta->save();
                    }
                    
                }
            
                //KOLEKSI JAWABAN UNTUK REKAP
                $pp_=json_decode($p->json)->pertanyaan;
                foreach ($pp_ as $aa) {
                    if ($aa->tipe === 3 or $aa->tipe === 1) { //tipe pertanyaan piliihan ganda
                        $key = $jawaban[$aa->id];
                        if ( array_key_exists($aa->id,$pp)=== false) {
                            $opsi = [];
                            //jika belum ada data untuk pertanyaan ini, bisa init per opsi dgn nilai 0
                            foreach ($aa->opsi as $o) {
                                if (is_object($o)) {
                                    $opsi[$o->{'0'}] = [0,0]; //BENTUK array bedain Laki,Perempuan
                                } else {
                                    $opsi[$o] = [0,0];//BENTUK array bedain Laki,Perempuan
                                }
                            }
                            $pp[$aa->id]=$opsi;
                        }
                        $pp[$aa->id][$key][$gender==='L'?0:1] += 1;

                        //assign siswa ke meta dari opsi jawaban
                        $metakey="rekap_{$id_sekolah}_{$jawaban_raw->id_formulir}_{$aa->id}_{$key}_{$gender}";
                        Storage::append("rekap/".$metakey.".txt", $jawaban_raw->getUser->nama.",".$jawaban_raw->getUser->id);
                        // $meta = Metadata::where('key',$metakey)->first();
                        // if($meta === NULL){
                        // if(Storage::exists("rekap".$metakey.".txt") === FALSE){
                            // $meta = Metadata::make([
                            //     'key'=> $metakey,
                            //     'value'=>$jawaban_raw->getUser->nama.",".$jawaban_raw->getUser->id,
                            // ]);
                        //     Storage::append("rekap".$metakey.".txt", $jawaban_raw->getUser->nama.",".$jawaban_raw->getUser->id);
                        // }
                        // else{
                            // $meta->value.="\n".$jawaban_raw->getUser->nama.",".$jawaban_raw->getUser->id;
                        //     Storage::append("rekap".$metakey.".txt", "\n".$jawaban_raw->getUser->nama.",".$jawaban_raw->getUser->id);
                        // }
                        // $meta->save();
                    }
                }
                //END of KOLEKSI JAWABAN UNTUK REKAP
            }

            //finalisasi array ke csv string
            if ($is_new) {
                $dummy = array_fill(0, count($csv_arr), 0);
                // $dummy = implode(',',$dummy);

                if ($sklh_kelas===1) {
                    $csv = array_fill(0, 6, $dummy);
                } elseif ($sklh_kelas===7 or $sklh_kelas===10) {
                    $csv = array_fill(0, 3, []);
                }
            }

            $csv_gabungan=[];
        
            //jumlahin csv per kolom
            for ($i=0; $i <count($csv[0]) ; $i++) {
                $sum = array_sum(array_column($csv, $i));
                array_push($csv_gabungan, $sum);
            }

            $csv[max($kelas-$sklh_kelas, 0) ] = $csv_arr;
            foreach ($csv as $i=>$c) {
                $csv[$i]=implode(',', $c);
            }

            $simpulan = implode('\n', $csv);
            $csv_gabungan = implode(',', $csv_gabungan);
            //END of SIMPULAN

            //     //inisialisasi json rekap jika belum ada
            //     $allRes = [];
            //     foreach( $pertanyaan as $p){
            //         $res = (object) [];
            //         $json = json_decode($p->json);
            //         $res->judul = $p->judul;
            //         $res->pertanyaan = $json->pertanyaan;
            //         foreach ($json->pertanyaan as $pp) {
            //             if($pp->tipe === 3){    //pertanyaan pilgan dengan tambahan jawaban
            //                 $opsi = [];
            //                 $tambahan = [];
            //                 foreach ($pp->opsi as $o) {
            //                     if(is_object($o)){
            //                         $opsi[$o->{'0'}] = 0;
            //                         $tambahan[$o->{'0'}] = $o->{'if-selected'};
            //                         $tambahan[$o->{'0'}]->jawaban = null;
            //                     }else{
            //                         $opsi[$o] = 0;
            //                     }
            //                 }
            //                 $pp->opsi = (object) $opsi;
            //                 $pp->tambahan = $tambahan;
            //             }else if($pp->tipe === 1){ //pertanyaan tipe 1 jaga-jaga
            //                 $opsi = [];
            //                 foreach ($pp->opsi as $o) {
            //                     $opsi[$o] = 0;
            //                 }
            //                 $pp->opsi = (object) $opsi;
            //             }else if($pp->tipe === 2 || $pp->tipe === 4){ //pertanyaan isian atau upload gambar
            //                 $pp->jawaban = null;
            //             }
            //         }
            //         $allRes[] = $res;
            //     }
            // }else{
            //     $allRes = json_decode($rekap->json, false);
            // }

            // foreach( $allRes as $a){
            //     foreach ($a->pertanyaan as $aa) {
            //         switch ($aa->tipe) {
            //             case 3:
            //                 $key = $jawaban[$aa->id];
            //                 $aa->opsi->{$key}+=1;
            //                 $aa->tambahan = (object) $aa->tambahan;
            //                 try {
            //                     if($aa->tambahan->{$key}){
            //                         $id_ = $aa->tambahan->{$key}->id;
            //                         //append to file
            //                         $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$id_.".html";
            //                         Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$id_].'" disabled></div>');
            //                         $aa->tambahan->{$key}->jawaban = $formulir->id."_".$id_.".html";
            //                     }
            //                 } catch (\Throwable $th) {
            //                     //throw $th;
            //                 }
            //                 break;
            //             case 1:
            //                 $key = $jawaban[$aa->id];
            //                 $aa->opsi->{$key}+=1;
            //             case 2:
            //                 $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
            //                 Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$aa->id].'" disabled></div>');
            //                 $aa->jawaban = $formulir->id."_".$aa->id.".html";
            //                 break;
            //             case 4:
            //                 $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
            //                 preg_match('/[^\/]+$/', $jawaban[$aa->id], $matches);
            //                 $judulGambar = $matches[0];
            //                 Storage::append($namafile, '<div class="form-group"><a href="'.$jawaban[$aa->id].'" target="_blank" ><input type="text" class="form-control" value="Link: '.$judulGambar.'" disabled></a></div>');
            //                 $aa->jawaban = $formulir->id."_".$aa->id.".html";
            //                 break;
            //         }
            //     }
            // }

            $rekap->fill([ 'json'=>json_encode($pp), 'csv'=>$simpulan, 'csv_gabungan'=>$csv_gabungan ]);
            $jawaban_raw->fill(['status_rekap'=>1]);
            $jawaban_raw->save();
            $rekap->save();
        }
    }
}
