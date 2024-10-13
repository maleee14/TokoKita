@extends('layouts.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir, false) }}
@endsection

@push('css')
    <!-- Date Picker -->
    <link rel="stylesheet"
        href="{{ asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="updatePeriode()" class="btn btn-sm btn-info"><i class="fa fa-plus-circle"></i> Ubah
                        Periode</button>
                    <a href="{{ route('laporan.export_pdf', [$tanggal_awal, $tanggal_akhir]) }}" target="blank"
                        class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"> Export PDF</i></a>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th width="20%">Tanggal</th>
                            <th>Penjualan</th>
                            <th>Pembelian</th>
                            <th>Pengeluaran</th>
                            <th>Pendapatan</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @includeIf('laporan.form')
@endsection

@push('script')
    <!-- datepicker -->
    <script src="{{ asset('AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('laporan.data', [$tanggal_awal, $tanggal_akhir]) }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'penjualan'
                    },
                    {
                        data: 'pembelian'
                    },
                    {
                        data: 'pengeluaran'
                    },
                    {
                        data: 'pendapatan'
                    },
                ],
                dom: 'Brt',
                bSort: false,
                bPaginate: false,
            });

            4
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

        });

        function updatePeriode(url) {
            $('#modal-form').modal('show');
        }
    </script>
@endpush
