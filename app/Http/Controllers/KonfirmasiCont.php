<?php
 
namespace App\Http\Controllers;
use App\Models\Pelatihan;
use App\Models\Peserta;
use App\Models\Cabang;
use App\Models\Forwardconfirm;
use Carbon\Carbon;
use DataTables;
use Jobs;
use App\Jobs\BroadcastWA;
use Illuminate\Http\Request;

class KonfirmasiCont extends Controller
{
    public function index(Request $request)
    {
        return view('e_confirm.list');
    }
    
    public function diklat_cabang_select(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Cabang::select('id','name','kode','kabupaten_id')->with('kabupaten')
            		->where('name','LIKE','%' .$search . '%')
                    ->orWhere('kode', 'LIKE', '%' .$search . '%')
                    ->orWhere('kabupaten_id', 'LIKE', '%' .$search . '%')
            		->get();
        }else{
            $data = Cabang::select('id','name','kode','kabupaten_id')->with('kabupaten')->get();
        }
        return response()->json($data);
    }

    public function data_diklat_menunggu_konfirmasi(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->dari))
            {
                $data   = Pelatihan::with('cabang','program')->withCount('peserta')->orderBy('id','desc')
                ->whereBetween('tanggal', array($request->dari, $request->sampai));
                return DataTables::of($data)
                        ->addColumn('peserta', function($data){
                            if ($data->peserta_count == 0) {
                                # code...
                                return '<a href="/daftar-data-peserta/'.$data->slug.'" class="text-danger">'.$data->peserta_count.' - '.$data->keterangan.'<a>';
                            } else {
                                # code...
                                return '<a href="/daftar-data-peserta/'.$data->slug.'" class="text-success">'.$data->peserta_count.' - '.$data->keterangan.'<a>';
                            }
                        })
                        ->addColumn('cabang', function ($data) {
                            return $data->cabang->name;
                        })
                        ->addColumn('program', function ($data) {
                            return $data->program->name;
                        })
                        ->addColumn('unduh', function($data){
                            $actionBtn2 = '<button data-id="'.$data->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-download"><i class="fa fa-download"></i></button>';
                            return $actionBtn2;
                        })
                        ->addColumn('tanggal', function($data){
                            if ($data->sampai_tanggal !== null) {
                                # code...
                                return Carbon::parse($data->tanggal)->isoFormat('dddd, D MMMM Y').' - '.
                                Carbon::parse($data->sampai_tanggal)->isoFormat('dddd, D MMMM Y');
                            }else{
                                return Carbon::parse($data->tanggal)->isoFormat('dddd, D MMMM Y');
                            }
                        })
                ->rawColumns(['cabang','program','peserta','unduh','tanggal'])
                ->make(true);
            }else{
                $data   = Pelatihan::with('cabang','program')->withCount('peserta')->orderBy('id','desc');
                return DataTables::of($data)
                        ->addColumn('peserta', function($data){
                            if ($data->peserta_count == 0) {
                                # code...
                                return '<a href="/daftar-data-peserta/'.$data->slug.'" class="text-danger">'.$data->peserta_count.' - '.$data->keterangan.'<a>';
                            } else {
                                # code...
                                return '<a href="/daftar-data-peserta/'.$data->slug.'" class="text-success">'.$data->peserta_count.' - '.$data->keterangan.'<a>';
                            }
                        })
                        ->addColumn('cabang', function ($data) {
                            return $data->cabang->name;
                        })
                        ->addColumn('program', function ($data) {
                            return $data->program->name;
                        })
                        ->addColumn('unduh', function($data){
                            $actionBtn2 = '<button data-id="'.$data->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-download"><i class="fa fa-download"></i></button>';
                            $actionBtn2 .= ' <button class="btn btn-sm btn-success"><i class="fa fa-file-import"></i></button>';
                            return $actionBtn2;
                        })
                        ->addColumn('tanggal', function($data){
                            if ($data->sampai_tanggal !== null) {
                                # code...
                                return Carbon::parse($data->tanggal)->isoFormat('dddd, D MMMM Y').' - '.
                                Carbon::parse($data->sampai_tanggal)->isoFormat('dddd, D MMMM Y');
                            }else{
                                return Carbon::parse($data->tanggal)->isoFormat('dddd, D MMMM Y');
                            }
                        })
                ->rawColumns(['cabang','program','peserta','unduh','tanggal'])
                ->make(true);
            }
        }
    }

    public function daftar_peserta_diklat_menunggu_konfirmasi(Request $request, $slug_diklat)
    {
        $diklat = Pelatihan::where('slug',$slug_diklat)->first();
        return view('tilawatipusat.konfirmasi.peserta',compact('diklat'));
    }

    public function acc(Request $request)
    {
        if(request()->ajax())
        {

            $data = Peserta::updateOrCreate(
                [
                  'id' => $request->id
                ],
                [
                    'status' => $request->acc,
                ]
            );
            $data2 = Pelatihan::where('id',$data->pelatihan_id)->first();
            $linkwa= $data2->groupwa;

            $alasan= $request->alasan;

            if ($request->acc == 1) {
                # code...
                # send wa

                $curl = curl_init();
                $token = "ErPMCdWGNfhhYPrrGsTdTb1vLwUbIt35CQ2KlhffDobwUw8pgYX4TN5rDT4smiIc";
                $payload = [
                    "data" => [
                        [
                            'phone' => $data->telp,
                            'message' => '*TILAWATI PUSAT - '.strtoupper($data2->program->name).'*. 
                            *Yth. '.strtoupper($data->name).'*. Pendaftaran anda telah kami terima, silahkan bergabung pada group whatsapp berikut ( '.$data2->groupwa.' )
            
                            *CATATAN*
                            Simpan nomor ini untuk mengaktifkan link group Whatsapp diatas.
                            *PESAN INI TIDAK UNTUK DISEBAR LUASKAN*',
                            'secret' => false, // or true
                            'retry' => false, // or true
                            'isGroup' => false, // or true
                        ]
                    ]
                ];
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                        "Content-Type: application/json"
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
                curl_setopt($curl, CURLOPT_URL, "https://solo.wablas.com/api/v2/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($curl);
                curl_close($curl);
                //
                return response()->json(
                    [
                      'success' => 'Pendaftaran Peserta Telah Disetujui!',
                      'message' => 'Pendaftaran Peserta Telah Disetujui!'
                    ]
                );
            }else{
                # send wa
                //hapus file di subdomain registrasi bagi yang datanya ditolak
                // foreach ($data->filepeserta as $key => $value) {
                //     # code...
                //     File::delete('https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'');
                // }
                //hapus peserta bagi yang datanya ditolak agar bisa registrasi lagi
                $curl = curl_init();
                $token = "ErPMCdWGNfhhYPrrGsTdTb1vLwUbIt35CQ2KlhffDobwUw8pgYX4TN5rDT4smiIc";
                $payload = [
                    "data" => [
                        [
                            'phone' => $data->telp,
                            'message' => '*TILAWATI PUSAT - '.strtoupper($data2->program->name).'*
                            *Yth. '.strtoupper($data->name).'*. Maaf, Pendaftaran anda belum dapat kami terima karena :  
                            *'.$alasan.'*.
            
                            Untuk melanjutkan pendaftaran bisa klik link dibawah ini.
                            https://registrasi.nurulfalah.org/'.$data2->slug.'.',
                            'secret' => false, // or true
                            'retry' => false, // or true
                            'isGroup' => false, // or true
                        ]
                    ]
                ];
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                        "Content-Type: application/json"
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
                curl_setopt($curl, CURLOPT_URL, "https://solo.wablas.com/api/v2/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($curl);
                curl_close($curl);

                $data->delete();

                return response()->json(
                    [
                      'success' => 'Pendaftaran Peserta Telah Ditolak!',
                      'message' => 'Pendaftaran Peserta Telah Ditolak!'
                    ]
                );
            }
        }
    }

    public function daftar_peserta($cabang_id)
    {
        if(request()->ajax())
        {
            $f = Forwardconfirm::orderBy('created_at', 'desc')->where('cabang_id',$cabang_id)->first();
            if ($f !== null) {
                # code...
                $p = Peserta::with('kabupaten')->with('pelatihan')->with('filepeserta')->with('program')->with('cabang')
                        ->where('pelatihan_id', $f->pelatihan_id)->where('cabang_id',$f->cabang_id)->where('status',0);
                        // return response()->json($p);
                        return DataTables::of($p)

                        ->addColumn('registrasi', function ($data) {
                            if ($data->filepeserta->count()==0) {
                                # code...
                                return '<span class="badge badge-danger">kosong</span>';
                            } else {
                                # code...
                                foreach ($data->filepeserta as $key => $value) {
                                    # code...
                                    if ($value->status == 0) {
                                        # code...
                                        $x[] = 
                                        '<a href="#" class="text-white badge" style="background-color: rgb(112, 150, 255)" data-toggle="modal" data-target="#modal_file"
                                        data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                        data-name="'.$data->name.'"
                                        data-img_name="'.$value->registrasi->name.'"
                                        data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                    } elseif ($value->status == 1) {
                                        # code...
                                        $x[] = 
                                        '<a href="#" class="text-white badge" style="background-color: red" data-toggle="modal" data-target="#modal_file"
                                        data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                        data-name="'.$data->name.'"
                                        data-img_name="'.$value->registrasi->name.'"
                                        data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                    } else{
                                        # code...
                                        $x[] = 
                                        '<a href="#" class="text-white badge" style="background-color: lightgreen" data-toggle="modal" data-target="#modal_file"
                                        data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                        data-name="'.$data->name.'"
                                        data-img_name="'.$value->registrasi->name.'"
                                        data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                    }
                                
                                }
                                return implode(" - ", $x);
                            }
                        })
                            ->addColumn('kabupaten', function ($data) {
                                if ($data->kabupaten == null) {
                                    # code...
                                    return "-";
                                }else{
                                    return $data->kabupaten->nama;
                                }
                            })
                            ->addColumn('cabang', function ($data) {
                                if ($data->pelatihan->program->name == 'Diklat Munaqisy Cabang') {
                                    # code...
                                    return $data->asal_cabang;
                                }else{
                                    return $data->pelatihan->cabang->name;
                                }
                            })
    
                            ->addColumn('status', function ($data) {
                                if ($data->status == 0) {
                                    # code...
                                    $stat = '<span class="badge badge-warning">menunggu</span>';
                                    return $stat;
                                }elseif ($data->status == 2) {
                                    # code...
                                    $stat = '<span class="badge badge-danger">ditolak</span>';
                                    return $stat;
                                } 
                                elseif ($data->status == 1) {
                                    # code...
                                    $stat = '<span class="badge badge-success">disetujui</span>';
                                    return $stat;
                                } 
                            })
                            
                            ->addColumn('action', function($data){
                                $actionBtn = ' <a style="width:50px" href="#" data-id="'.$data->id.'" data-toggle="modal" data-target="#hapusData" class="btn btn-sm btn-outline btn-danger "><i class="fa fa-close"></i></a>';
                                $actionBtn .= ' <a style="width:50px" href="#" data-id="'.$data->id.'" data-name="'.$data->name.'" data-toggle="modal" data-target=".modal-acc" class="btn btn-sm btn-outline btn-success "><i class="fa fa-check"></i></a>';
                                return $actionBtn;
                            })
                            ->addColumn('no', function ($data) {
                                
                            })
                            ->addColumn('program', function ($data) {
                                return $data->pelatihan->program->name;
                            })
                    ->rawColumns(['action','kabupaten','registrasi','status','program'])
                    ->make(true);$p = Peserta::with('kabupaten')->with('pelatihan')->with('filepeserta')->with('program')->with('cabang')
                    ->where('pelatihan_id', $f->pelatihan_id)->where('cabang_id',$f->cabang_id)->where('status',0);
                    // return response()->json($p);
                    return DataTables::of($p)

                    ->addColumn('registrasi', function ($data) {
                        if ($data->filepeserta->count()==0) {
                            # code...
                            return '<span class="badge badge-danger">kosong</span>';
                        } else {
                            # code...
                            foreach ($data->filepeserta as $key => $value) {
                                # code...
                                if ($value->status == 0) {
                                    # code...
                                    $x[] = 
                                    '<a href="#" class="text-white badge" style="background-color: rgb(112, 150, 255)" data-toggle="modal" data-target="#modal_file"
                                    data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                    data-name="'.$data->name.'"
                                    data-img_name="'.$value->registrasi->name.'"
                                    data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                } elseif ($value->status == 1) {
                                    # code...
                                    $x[] = 
                                    '<a href="#" class="text-white badge" style="background-color: red" data-toggle="modal" data-target="#modal_file"
                                    data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                    data-name="'.$data->name.'"
                                    data-img_name="'.$value->registrasi->name.'"
                                    data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                } else{
                                    # code...
                                    $x[] = 
                                    '<a href="#" class="text-white badge" style="background-color: lightgreen" data-toggle="modal" data-target="#modal_file"
                                    data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                    data-name="'.$data->name.'"
                                    data-img_name="'.$value->registrasi->name.'"
                                    data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                }
                            
                            }
                            return implode(" - ", $x);
                        }
                    })
                        ->addColumn('kabupaten', function ($data) {
                            if ($data->kabupaten == null) {
                                # code...
                                return "-";
                            }else{
                                return $data->kabupaten->nama;
                            }
                        })
                        ->addColumn('cabang', function ($data) {
                            if ($data->pelatihan->program->name == 'Diklat Munaqisy Cabang') {
                                # code...
                                return $data->asal_cabang;
                            }else{
                                return $data->pelatihan->cabang->name;
                            }
                        })

                        ->addColumn('status', function ($data) {
                            if ($data->status == 0) {
                                # code...
                                $stat = '<span class="badge badge-warning">menunggu</span>';
                                return $stat;
                            }elseif ($data->status == 2) {
                                # code...
                                $stat = '<span class="badge badge-danger">ditolak</span>';
                                return $stat;
                            } 
                            elseif ($data->status == 1) {
                                # code...
                                $stat = '<span class="badge badge-success">disetujui</span>';
                                return $stat;
                            } 
                        })
                        
                        ->addColumn('action', function($data){
                            $actionBtn = ' <a style="width:50px" href="#" data-id="'.$data->id.'" data-toggle="modal" data-target="#hapusData" class="btn btn-sm btn-outline btn-danger "><i class="fa fa-close"></i></a>';
                            $actionBtn .= ' <a style="width:50px" href="#" data-id="'.$data->id.'" data-name="'.$data->name.'" data-toggle="modal" data-target=".modal-acc" class="btn btn-sm btn-outline btn-success "><i class="fa fa-check"></i></a>';
                            return $actionBtn;
                        })
                        ->addColumn('no', function ($data) {
                            
                        })
                        ->addColumn('program', function ($data) {
                            return $data->pelatihan->program->name;
                        })
                ->rawColumns(['action','kabupaten','registrasi','status','program'])
                ->make(true);
            }else {
                # code...
                return response()->json(
                    [
                        'pesan' => 'kosong'
                    ]
                );
            }
            
        }
    }

    public function data_peserta_diklat_menunggu_konfirmasi(Request $request)
    {
        if(request()->ajax())
        {
            
                $data   = Peserta::with('kabupaten')->with('pelatihan')->with('filepeserta')->with('program')->with('cabang')->where('status', 0);
                return DataTables::of($data)

                    ->addColumn('registrasi', function ($data) {
                        if ($data->filepeserta->count()==0) {
                            # code...
                            return '<span class="badge badge-danger">kosong</span>';
                        } else {
                            # code...
                            foreach ($data->filepeserta as $key => $value) {
                                # code...
                                if ($value->status == 0) {
                                    # code...
                                    $x[] = 
                                    '<a href="#" class="text-white badge" style="background-color: rgb(112, 150, 255)" data-toggle="modal" data-target="#modal_file"
                                    data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                    data-name="'.$data->name.'"
                                    data-img_name="'.$value->registrasi->name.'"
                                    data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                } elseif ($value->status == 1) {
                                    # code...
                                    $x[] = 
                                    '<a href="#" class="text-white badge" style="background-color: red" data-toggle="modal" data-target="#modal_file"
                                    data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                    data-name="'.$data->name.'"
                                    data-img_name="'.$value->registrasi->name.'"
                                    data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                } else{
                                    # code...
                                    $x[] = 
                                    '<a href="#" class="text-white badge" style="background-color: lightgreen" data-toggle="modal" data-target="#modal_file"
                                    data-file="https://registrasi.nurulfalah.org/file_peserta/'.$value->file.'"
                                    data-name="'.$data->name.'"
                                    data-img_name="'.$value->registrasi->name.'"
                                    data-jenis="'.$value->registrasi->jenis.'">'.$value->registrasi->name.'</a>';
                                }
                            
                            }
                            return implode(" - ", $x);
                        }
                    })
                        ->addColumn('kabupaten', function ($data) {
                            if ($data->kabupaten == null) {
                                # code...
                                return "-";
                            }else{
                                return $data->kabupaten->nama;
                            }
                        })
                        ->addColumn('cabang', function ($data) {
                            if ($data->pelatihan->program->name == 'Diklat Munaqisy Cabang') {
                                # code...
                                return $data->asal_cabang;
                            }else{
                                return $data->pelatihan->cabang->name;
                            }
                        })

                        ->addColumn('status', function ($data) {
                            if ($data->status == 0) {
                                # code...
                                $stat = '<span class="badge badge-warning">menunggu</span>';
                                return $stat;
                            }elseif ($data->status == 2) {
                                # code...
                                $stat = '<span class="badge badge-danger">ditolak</span>';
                                return $stat;
                            } 
                            elseif ($data->status == 1) {
                                # code...
                                $stat = '<span class="badge badge-success">disetujui</span>';
                                return $stat;
                            } 
                        })
                        
                        ->addColumn('action', function($data){
                            $actionBtn = ' <a style="width:50px" href="#" data-id="'.$data->id.'" data-toggle="modal" data-target="#hapusData" class="btn btn-sm btn-outline btn-danger "><i class="fa fa-close"></i></a>';
                            $actionBtn .= ' <a style="width:50px" href="#" data-id="'.$data->id.'" data-name="'.$data->name.'" data-toggle="modal" data-target=".modal-acc" class="btn btn-sm btn-outline btn-success "><i class="fa fa-check"></i></a>';
                            return $actionBtn;
                        })
                        ->addColumn('no', function ($data) {
                            
                        })
                        ->addColumn('program', function ($data) {
                            return $data->pelatihan->program->name;
                        })
                ->rawColumns(['action','kabupaten','registrasi','status','program'])
                ->make(true);
        }
    }

    public function broadcastWA(Request $request)
    {
        $pelatihan_id = $request->pelatihan_id;
            // $this->dispatch(new QRJob($pelatihan_id));
            $data = Peserta::where('pelatihan_id', $pelatihan_id)
            ->chunk(1, function($pesertass) {
                foreach ($pesertass as $value) {
                    // apply some action to the chunked results here
                    BroadcastWA::dispatch($value);
                }
            });
            return response()->json(
                [
                  'success' => 'OKE!',
                  'message' => 'OKE!'
                ]
            );
    }
}
