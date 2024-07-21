@extends('layouts.admin')
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
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Data Absen</li>
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
                        <h3 class="box-title">Data Absen : {{ date('F Y') }}</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('admin.addAbsen') }}" type="button" class="btn btn-info btn-md"
                                onclick="return confirm('Apakah anda yakin ?')"><i class="fa fa-plus"> Form Absen
                                </i></a>
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
                                    <th>Izin</th>
                                    <th>Sakit</th>
                                    <th>Alpha</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$absen as $key => $value)
                                    <tr>
                                        <td>{{ @$value->id }}</td>
                                        <td>{{ @$value->User->nip }}</td>
                                        <td>{{ @$value->User->name }}</td>
                                        <td>{{ @$value->User->Jabatan->name }}</td>
                                        <td>{{ @$value->izin }}</td>
                                        <td>{{ @$value->sakit }}</td>
                                        <td>{{ @$value->alpha }}</td>
                                        <td>
                                            @if (@$value->is_submit != 1)
                                                <button class="btn btn-xs btn-success btn-edit-penggajian"><i
                                                        class="fa fa-edit">
                                                        Absen</i></button> &nbsp;
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-form-edit-penggajian" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Data Absen</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.updateAbsen') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="hidden" name="id" readonly class="form-control" placeholder="ID" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nomor Induk Karyawan:</label>
                            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Karyawan"
                                readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nama Karyawan:</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Karyawan" readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Izin</label>
                            <input type="number" name="izin" class="form-control" placeholder="Jumlah Izin" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Jumlah Sakit</label>
                            <input type="number" name="sakit" class="form-control" placeholder="Jumlah Sakit" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Jumlah Alpha</label>
                            <input type="number" name="alpha" class="form-control" placeholder="Jumlah Alpha" required>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
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
