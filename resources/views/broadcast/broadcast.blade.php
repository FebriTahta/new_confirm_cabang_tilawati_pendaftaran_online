@extends('layouts.master')

@section('head')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="{{ URL::asset('tilawatipusat/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />

    <style>
        /* table.dataTable.peserta td:nth-child(1) {
        width: 60px;
        word-break: break-all;
        white-space: pre-line;
        text-align: center;
        }
        table.dataTable.peserta th:nth-child(1) {
        width: 50px;
        word-break: break-all;
        white-space: pre-line;
        text-align: center;
        } */
    </style>
@endsection

@section('content')
<div class="block">
    <section class="recipe-section-two" style="background-image: url({{ asset('tilawatipusat/landing/images/background/7.jpg') }})">
        <div class="auto-container">
            <!-- Sec Title -->
            <div class="sec-title centered">
                <h5>
                    WHATSAPP BROADCASTER
                </h5>
                <div class="title">Broadcast Diklat Ke Peserta</div>
                <div class="separate"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="auto-container">
                    <!-- Sec Title Two -->
                    <div class="table-responsive">
                        <span class="sec-title-two">
                            <a href="#" class="title">Data Peserta</a>
                            <input type="hidden" id="pelatihan_ids" value="">
                        </span><br>
                        <div class="text-left">
                            <button class="btn btn-sm btn-outline-info" data-target="#modal-target" data-toggle="modal">broadcast</button>
                            <button class="btn btn-sm btn-outline-danger">hapus data</button>
                        </div><br>
                        <table id="data" class="table peserta table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                            <thead style="text-transform: capitalize" class="text-success">
                                <tr>
                                    <th>no</th>
                                    <th>nama</th>
                                </tr>
                            </thead>
                            <tbody style="text-transform: uppercase; font-size: 12px">
                            </tbody>
                        </table>
                    </div>
                    <div class="separator"></div>
                </div>
            </div>
        </div>
        {{-- file --}}

        <div class="col-sm-6 col-md-3 m-t-30">
            <div class="modal fade bs-example-modal-cabang" id="modal-target" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0">IMPORT DATA TARGET </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-xl-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <form id="importcabang"  method="POST" enctype="multipart/form-data">@csrf
                                                <input type="hidden" id="import_tipe" value="munaqisy">
                                                <div class="form-group">
                                                    <label for="">Import Data "Target Broadcast" (hanya Excel File format .xlsx)</label>
                                                    <input type="file" class="form-control" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="import" id="btnimport" class="btn btn-info" value="Import" />
                                                </div>
                                            </form>
                                        </div><!-- container fluid -->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    
        <div class="col-sm-6 col-md-3 m-t-30">
            <div class="modal fade" id="modal-bc" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="col-xl-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <form id="formacc2"  method="POST" enctype="multipart/form-data">@csrf
                                                <div class="form-group text-center">
                                                    <h5>Tulis alasan pendaftaran peserta tersebut tidak diterima!</h5>
                                                    <input type="hidden" class="form-control text-capitalize" id="id" name="id" required>
                                                    <input type="hidden" value="2" name="acc">
                                                </div>
                                                <div class="row" style="text-align: center">
                                                    <div class="form-group col-12 col-xl-12">
                                                        <textarea name="alasan" id="alasan" cols="10" rows="2" class="form-control" required></textarea>
                                                    </div>
                                                    <div class="form-group col-6 col-xl-6">
                                                        <input type="submit" id="btnbc" class="btn btn-info" value="Ya, BC!" />
                                                    </div>
                                                    <div class="form-group col-6 col-xl-6">
                                                        <button type="button" id="cancel2" class="btn btn-secondary" data-dismiss="modal">
                                                            Close!
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- container fluid -->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    
        
    </section>
</div>
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('tilawatipusat/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('tilawatipusat/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('tilawatipusat/libs/pdfmake/pdfmake.min.js')}}"></script>

    <!-- Datatable init js -->
    <script src="{{ URL::asset('tilawatipusat/js/pages/datatables.init.js')}}"></script>

    <!-- Toast -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script>
        $('#acc').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-body #nama_peserta').val(name);
                modal.find('.modal-body #id').val(id);
                console.log(name);
            })
            //tolak pendaftaran
            $('#modal-bc').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                // id = button.data('id')
                var modal = $(this)
                // modal.find('.modal-body #id').val(id);
            })
            
            

            $('#formacc2').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                type:'POST',
                url: "{{ route('acc')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $('#btntolak').attr('disabled','disabled');
                    $('#btntolak').val('Proccessing');
                },
                success: function(data){
                    if(data.success)
                    {
                        //sweetalert and redirect
                        toastr.error(data.success);
                        // $("#cancel2").click();
                        var oTable = $('#data').dataTable();
                        oTable.fnDraw(false);
                        $('#btntolak').val('Ya, Tolak!');
                        $("#formacc2")[0].reset();
                        // $('#hapusData').modal('hide');
                        $('#btntolak').attr('disabled',false);
                    }
                },
                error: function(data)
                {
                    console.log(data);
                    }
                });
            });
            
            $(document).ready(function(){
            $('#data').DataTable({
                //karena memakai yajra dan template maka di destroy dulu biar ga dobel initialization
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/daftar-broadcast/",
                },
                columns: [
                    {data:'no',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },
                    {data:'name',name:'name'},
                    {data:'telp',name:'telp'},
                   
                ]
            });
        });
    </script>
@endsection