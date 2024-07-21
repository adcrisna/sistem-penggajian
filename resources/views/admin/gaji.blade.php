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
                        <h3 class="box-title">Data Gaji : {{ date('F Y') }}</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exportModal"><i
                                    class="fa fa-download"></i>
                                Laporan</button>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Laporan Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.pdfGaji') }}" method="post" target="_blank">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            <label>Bulan</label>
                            <select name="bulan" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
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
