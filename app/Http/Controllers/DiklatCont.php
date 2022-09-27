<?php

namespace App\Http\Controllers;
use App\Models\Pelatihan;
use App\Models\Peserta;
use App\Models\Program;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class DiklatCont extends Controller
{
    public function index()
    {
        return view('diklat.index');
    }

    public function index2()
    {
        return view('diklat.index2');
    }

    public function data_diklat(Request $request,$cabang_id)
    {
        if(request()->ajax())
        {
            $f = Forwardconfirm::orderBy('created_at', 'desc')->where('untuk',$cabang_id)->first();

            $data = Pelatihan::where('id',$f->pelatihan_id)->orderBy('tanggal','desc')->where('jenis','diklat')->where('cabang_id', 79)->get();
                    return DataTables::of($data)
                        ->addColumn('peserta', function($data){
                            $data2 = Peserta::where('pelatihan_id',$data->id)->where('status',1)->get()->count();
                            $data3 = Peserta::where('pelatihan_id',$data->id)->where('status',0)->get()->count();
                            return '<a href="/data-peserta/'.$data->id.'">'.$data2.' Fix - '.$data3.' Menunggu Konfirmasi'.'</a>';
                        })
                        ->addColumn('cabang', function($data){
                            return $data->cabang->name;
                        })
                        ->addColumn('program', function($data){
                            return $data->program->name;
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
                        ->addColumn('action', function($data){
                            if ($data->pendaftaran !== 'ditutup') {
                                # buka code...
                                $btn = '<button data-id="'.$data->id.'" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-tutup"> BUKA </button>';
                                return $btn;
                            }else {
                                # tutup code...
                                $btn = '<button data-id="'.$data->id.'"  class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-buka"> TUTUP </button>';
                                return $btn;
                            }
                        })
                        ->rawColumns(['cabang','program','peserta','tanggal','action'])
                        ->make(true);
        }
    }

    public function data_webinar(Request $request)
    {
        if(request()->ajax())
        {
            $data = Pelatihan::where('jenis','webinar')->orderBy('created_at', 'desc')->get();
                    return DataTables::of($data)
                        ->addColumn('peserta', function($data){
                            $data2 = Peserta::where('pelatihan_id',$data->id)->where('status',1)->get()->count();
                            $data3 = Peserta::where('pelatihan_id',$data->id)->where('status',0)->get()->count();
                            return '<a href="/data-peserta/'.$data->id.'">'.$data2.' Fix - '.$data3.' Menunggu Konfirmasi'.'</a>';
                        })
                        ->addColumn('cabang', function($data){
                            return $data->cabang->name;
                        })
                        ->addColumn('program', function($data){
                            return $data->program->name;
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
                        ->addColumn('action', function($data){
                            if ($data->pendaftaran !== 'ditutup') {
                                # buka code...
                                $btn = '<button data-id="'.$data->id.'" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-tutup"> BUKA </button>';
                                return $btn;
                            }else {
                                # tutup code...
                                $btn = '<button data-id="'.$data->id.'"  class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-buka"> TUTUP </button>';
                                return $btn;
                            }
                        })
                        ->rawColumns(['cabang','program','peserta','tanggal','action'])
                        ->make(true);
        }
    }

    public function data_peserta($pelatihan_id)
    {
        $data = Pelatihan::where('id',$pelatihan_id)->first();
        return view('e_confirm.peserta',compact('data'));
    }

    public function daftar_data_peserta(Request $request,$pelatihan_id)
    {
        if(request()->ajax())
        {
            
                $data   = Peserta::where('pelatihan_id',$pelatihan_id)->with('kabupaten')->with('pelatihan')->with('filepeserta')->with('cabang');
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
                            return $data->pelatihan->cabang->name;
                            
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
                ->rawColumns(['action','kabupaten','registrasi','status'])
                ->make(true);
        }
    }

    public function buka_tutup(Request $request)
    {
        if(request()->ajax())
        {

            $data = Pelatihan::updateOrCreate(
                [
                  'id' => $request->id
                ],
                [
                    'pendaftaran' => $request->pendaftaran,
                ]
            );
            return response()->json(
                [
                  'success' => 'Pendaftaran '.$data->pendaftaran.'',
                  'message' => 'Pendaftaran '.$data->pendaftaran.''
                ]
            );

        }
    }

    public function page_broadcast()
    {
        return view('broadcast.broadcast');
    }

    public function daftar_broadcast(Request $request)
    {
        if(request()->ajax())
        {
            $data = Broadcast::all();
            return DataTables::of($data)
            ->make(true);
        }
    }

    public function import_target()
    {
       
    }

}
