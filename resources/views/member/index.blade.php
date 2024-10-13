@extends('layouts.master')

@section('title')
    Daftar Member
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Member</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('member.store') }}')" class="btn btn-sm btn-success"><i
                            class="fa fa-plus-circle"></i> Tambah</button>
                    <button onclick="cetakMember('{{ route('member.cetak_member') }}')" class="btn btn-sm btn-info"><i
                            class="fa fa-id-card"></i> Cetak Member</button>
                </div>
                <div class="box-body table-responsive">
                    <form action="" class="form-member" method="POST">
                        @csrf
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th width="5%">
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th width="5%">No</th>
                                <th width="15%">Kode Member</th>
                                <th>Nama Member</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th width="15%">Action</th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @includeIf('member.form')
@endsection

@push('script')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('member.data') }}',
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_member'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'telepon'
                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    }
                ]
            });

            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            alert('Tidak dapat menyimpan data');
                            return;
                        });
                }
            });

            $('[name=select_all]').on('click', function() {
                $(':checkbox').prop('checked', this.checked);
            })

        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Member');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Member');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_kategori]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama]').val(response.nama)
                    $('#modal-form [name=telepon]').val(response.telepon)
                    $('#modal-form [name=alamat]').val(response.alamat)
                })
                .fail((errors) => {
                    alert('Tidak Dapat Menampilkan Data');
                    return;
                })
        }

        function deleteData(url) {
            if (confirm('Yakin Ingin Dihapus ?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak Dapat Menghapus Data');
                        return;
                    })
            }
        }

        function cetakMember(url) {
            // Get the number of checked checkboxes
            let checkedCount = $('.form-member input:checkbox:checked').length;

            // Check if less than 1 checkbox is checked
            if (checkedCount < 1) {
                alert('Pilih Data Yang Akan Dicetak');
                return;
            } else { // If checked, submit the form
                $('.form-member').attr('action', url).attr('target', '_blank').submit();
            }
        }
    </script>
@endpush
