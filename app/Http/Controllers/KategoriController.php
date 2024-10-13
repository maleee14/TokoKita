<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kategori.index');
    }

    public function data()
    {
        $kategori = Kategori::orderBy('id_kategori', 'desc')->get();

        return datatables()
            ->of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                return '
                <div class="btn-group" style="display: flex; justify-content: center;">
                    <button onclick="editForm(`' . route('kategori.update', $kategori->id_kategori) . '`)" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Edit</button>
                    <button onclick="deleteData(`' . route('kategori.destroy', $kategori->id_kategori) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"> Hapus</i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'nama_kategori' => 'required',
        // ]);

        // Kategori::create([
        //     'nama_kategori' => $request->nama_kategori,
        // ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json('Data Berhasil Di Simpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::find($id);

        return response()->json($kategori);
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
        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->update();

        return response()->json('Data Berhasil Di Simpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return response(null, 204);
    }
}
