@extends('layouts.master')

@section('title')
    Edit Profil
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Edit Profil</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12"></div>
        <div class="box">
            <form action="{{ route('user.update_profil') }}" method="POST" class="form-profil" data-toggle="validator"
                enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="alert alert-info alert-dismissible" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-check"></i> Perbahan Berhasil Disimpan
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-2 col-lg-offset-1 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $profil->name }}" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="foto" class="col-lg-2 col-lg-offset-1 control-label">Foto</label>
                        <div class="col-lg-4">
                            <input type="file" name="foto" id="foto" class="form-control"
                                onchange="preview('.tampil-foto', this.files[0], 100)">
                            <span class="help-block with-errors"></span><br>
                            <div class="tampil-foto"><img src="{{ url($profil->foto ?? '/') }}" width="100"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="old_password" class="col-lg-2 col-lg-offset-1 control-label">Password Lama</label>
                        <div class="col-lg-6">
                            <input type="password" name="old_password" id="old_password" class="form-control"
                                minlength="6">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-lg-2 col-lg-offset-1 control-label">Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password" id="password" class="form-control" minlength="6">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-lg-2 col-lg-offset-1 control-label">Konfirmasi
                            Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" data-match="#password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('#old_password').on('keyup', function() {
                if ($(this).val() != "") $('#password, #password_confirmation').attr('required', true);
                else $('#password, #password_confirmation').attr('required', false);
            })

            $('.form-profil').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('.form-profil').attr('action'),
                            type: $('.form-profil').attr('method'),
                            data: new FormData($('.form-profil')[0]),
                            async: false,
                            processData: false,
                            contentType: false,
                        })
                        .done((response) => {
                            $('[name=name]').val(response.name);
                            $('.tampil-foto').html(`<img src="${response.foto}" width="100">`);
                            $('.img-profil').attr('src', `${response.foto}`);

                            $('.alert').fadeIn();
                            setTimeout(() => {
                                $('.alert').fadeOut();
                            }, 5000);
                        })
                        .fail((errors) => {
                            if (errors.status = 422) {
                                alert(errors.responseJSON);
                            } else {
                                alert('Tidak Dabat Menyimpan Data !!');
                            }
                            return;
                        })
                }
            })
        });
    </script>
@endpush
