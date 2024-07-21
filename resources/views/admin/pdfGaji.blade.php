<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Gaji Karyawan</title>
    <style>
        .titleLaporan {
            margin-left: 400px;
        }

        .tableLaporan {
            margin-left: 25px;
        }

        table {
            border-collapse: collapse;
        }

        td {
            border: black 1x solid;
            padding: 5px;
            margin: 0px;
        }

        th {
            border: black 1x solid;
            padding: 5px;
            margin: 0px;
        }
    </style>
</head>

<body>
    <center>
        {{-- <img src="{{ public_path() . '/logo.jpeg' }}" alt="logo" width="270px"> --}}
    </center>
    <div class="titleLaporan">
        <h3>Laporan Data Gaji Karyawan</h3>
    </div>
    <center>
        <p>{{ date('F Y', strtotime($tanggal)) }}</p>
    </center>
    <div class="tableLaporan">
        @if ($gaji == '[]')
            <center>
                <p>Data Tidak Ditemukan!</p>
            </center>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nomor Induk</th>
                        <th width="280px">Nama</th>
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
        @endif
    </div>
</body>

</html>
