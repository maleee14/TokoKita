<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan</title>

</head>

<style>
    .text-center {
        text-align: center;
    }



    table {
        border-collapse: collapse;
        width: 100%;
        margin: 0 auto;
        /* This centers the table */
    }

    table td,
    table th {
        border: 1px solid #ccc;
        padding: 6px;
    }

    table th {
        background-color: initial;
        /* Ensure th cells retain their original background */
    }

    table tr:nth-child(odd) {
        background-color: #ebebeb;
        /* Light gray background for odd rows */
    }

    table tr:nth-child(even) {
        background-color: #fff;
        /* White background for even rows */
    }
</style>

<body>
    <h1 class="text-center">Laporan Pendapatan</h1>
    <h4 class="text-center">
        Tanggal {{ tanggal_indonesia($awal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h4>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Pengeluaran</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>{{ $col }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="{{ asset('AdminLTE-2/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>

</html>
