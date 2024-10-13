<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        return view('pengeluaran.index');
    }

    public function data()
    {
        $pengeluaran = Pengeluaran::orderBy('id_pengeluaran', 'desc')->get();

        return datatables()
            ->of($pengeluaran)
            ->addIndexColumn()
            ->addColumn('created_at', function ($pengeluaran) {
                return tanggal_indonesia($pengeluaran->created_at, false);
            })
            ->addColumn('rupiah', function ($pengeluaran) {
                return format_uang($pengeluaran->nominal);
            })
            ->addColumn('aksi', function ($pengeluaran) {
                return '
                <div class="btn-group" style="display: flex; justify-content: center;">
                    <button type="button" onclick="editForm(`' . route('pengeluaran.update', $pengeluaran->id_pengeluaran) . '`)" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Edit</button>
                    <button type="button" onclick="deleteData(`' . route('pengeluaran.destroy', $pengeluaran->id_pengeluaran) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"> Hapus</i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'created_at', 'rupiah'])
            ->make(true);
    }

    public function store(Request $request)
    {

        Pengeluaran::create($request->all());

        return response()->json('Data Berhasil Di Simpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengeluaran = Pengeluaran::find($id);

        return response()->json($pengeluaran);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Pengeluaran::find($id)->update($request->all());

        return response()->json('Data Berhasil Di Simpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pengeluaran::find($id)->delete();

        return response(null, 204);
    }
}
