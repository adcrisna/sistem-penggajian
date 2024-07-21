@extends('layouts.karyawan')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        img.zoom {
            width: 130px;
            height: 100px;
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            -ms-transition: all .2s ease-in-out;
        }

        .transisi {
            -webkit-transform: scale(1.8);
            -moz-transform: scale(1.8);
            -o-transform: scale(1.8);
            transform: scale(1.8);
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('karyawan.index') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Data Gaji</li>
        </ol>
        <br />
    </section>
    <section class="content">
        @if (\Session::has('msg_success'))
            <h5>
                <div class="alert alert-info">
                    {{ \Session::get('msg_success') }}
                </div>
            </h5>
        @endif
        @if (\Session::has('msg_error'))
            <h5>
                <div class="alert alert-danger">
                    {{ \Session::get('msg_error') }}
                </div>
            </h5>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Data Gaji</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-penggajian">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nomor Induk</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Gaji Pokok</th>
                                    <th>Tunjangan</th>
                                    <th>Uang Makan</th>
                                    <th>Potongan</th>
                                    <th>Total Gaji</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$gaji as $key => $value)
                                    <tr>
                                        <td>{{ @$value->id }}</td>
                                        <td>{{ @$value->User->nip }}</td>
                                        <td>{{ @$value->User->name }}</td>
                                        <td>{{ @$value->User->Jabatan->name }}</td>
                                        <td>Rp. {{ number_format(@$value->User->Jabatan->gaji, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format(@$value->User->Jabatan->tunjangan, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format(@$value->User->Jabatan->uang_makan, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format(@$value->potongan, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format(@$value->total_gaji, 0, ',', '.') }}</td>
                                        <td>{{ date('F Y', strtotime($value->updated_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        var table = $('#data-penggajian').DataTable();

        $('#data-penggajian').on('click', '.btn-edit-penggajian', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=nip]').val(row[1]);
            $('input[name=name]').val(row[2]);
            $('#modal-form-edit-penggajian').modal('show');
        });

        $(document).ready(function() {
            $('.zoom').hover(function() {
                $(this).addClass('transisi');
            }, function() {
                $(this).removeClass('transisi');
            });
        });
    </script>
@endsection
