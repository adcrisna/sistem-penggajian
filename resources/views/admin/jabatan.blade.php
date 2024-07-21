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
            <li class="active">Data Jabatan</li>
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
                        <h3 class="box-title">Data Jabatan</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-info btn-md" data-toggle="modal"
                                data-target="#modal-form-tambah-penggajian"><i class="fa fa-plus"> Tambah Data
                                </i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-penggajian">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Jabatan</th>
                                    <th>Gaji Pokok</th>
                                    <th>Tunjangan</th>
                                    <th>Uang Makan</th>
                                    <th style="display: none"></th>
                                    <th style="display: none"></th>
                                    <th style="display: none"></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$jabatan as $key => $value)
                                    <tr>
                                        <td>{{ @$value->id }}</td>
                                        <td>{{ @$value->name }}</td>
                                        <td>Rp. {{ number_format($value->gaji, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($value->tunjangan, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($value->uang_makan, 0, ',', '.') }}</td>
                                        <td style="display: none">{{ @$value->gaji }}</td>
                                        <td style="display: none">{{ @$value->tunjangan }}</td>
                                        <td style="display: none">{{ @$value->uang_makan }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-success btn-edit-penggajian"><i
                                                    class="fa fa-edit">
                                                    Ubah</i></button> &nbsp;
                                            <a href="{{ route('admin.deleteJabatan', $value->id) }}"><button
                                                    class=" btn btn-xs btn-danger"
                                                    onclick="return confirm('Apakah anda ingin menghapus data ini ?')"><i
                                                        class="fa fa-trash"> Hapus</i></button></a>
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
    <div class="modal fade" id="modal-form-tambah-penggajian" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Tambah Data Jabatan</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addJabatan') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label>Nama Jabatan:</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Jabatan" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Gaji</label>
                            <input type="number" name="gaji" class="form-control" placeholder="Gaji Pokok" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Tunjangan</label>
                            <input type="number" name="tunjangan" class="form-control" placeholder="Tunjangan" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Uang Makan</label>
                            <input type="number" name="uang_makan" class="form-control" placeholder="Uang Makan" required>
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
    <div class="modal fade" id="modal-form-edit-penggajian" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Ubah Data Jabatan</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.updateJabatan') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="hidden" name="id" readonly class="form-control" placeholder="ID" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nama Jabatan:</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Jabatan" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Gaji</label>
                            <input type="number" name="gaji" class="form-control" placeholder="Gaji Pokok" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Tunjangan</label>
                            <input type="number" name="tunjangan" class="form-control" placeholder="Tunjangan"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Uang Makan</label>
                            <input type="number" name="uang_makan" class="form-control" placeholder="Uang Makan"
                                required>
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
            $('input[name=name]').val(row[1]);
            $('input[name=gaji]').val(row[5])
            $('input[name=tunjangan]').val(row[6])
            $('input[name=uang_makan]').val(row[7])
            $('#modal-form-edit-penggajian').modal('show');
        });
        $('#modal-form-tambah-penggajian').on('show.bs.modal', function() {
            $('input[name=id]').val('');
            $('input[name=name]').val('');
            $('input[name=gaji]').val('')
            $('input[name=tunjangan]').val('')
            $('input[name=uang_makan]').val('')
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
