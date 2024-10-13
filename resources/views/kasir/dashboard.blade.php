@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-body text-center">
                <h1>Selamat Datang {{ auth()->user()->name }}</h1>
                <h2>Anda Login Sebagai <b><u>KASIR</u></b></h2>
                <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-lg"
                    style="margin-top: 2rem; margin-bottom: 2rem; ">Transaksi Baru</a>
            </div>
        </div>
    </div>
@endsection
