<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('member.index');
    }

    public function data()
    {
        $member = Member::orderBy('kode_member')->get();

        return datatables()
            ->of($member)
            ->addIndexColumn()
            ->addColumn('select_all', function ($member) {
                return '
                <input type="checkbox" name="id_member[]" value="' . $member->id_member . '">
                ';
            })
            ->addColumn('kode_member', function ($member) {
                return '<span class="label label-success">' . $member->kode_member . '</span>';
            })
            ->addColumn('aksi', function ($member) {
                return '
                <div class="btn-group" style="display: flex; justify-content: center;">
                    <button type="button" onclick="editForm(`' . route('member.update', $member->id_member) . '`)" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Edit</button>
                    <button type="button" onclick="deleteData(`' . route('member.destroy', $member->id_member) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"> Hapus</i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'select_all', 'kode_member'])
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
        $member = Member::latest()->first() ?? new Member();
        $kode_member = (int) $member->kode_member + 1;

        $date = date('Ym');

        //Mengambil 6 karakter pertama, membandingkannya dengan variabel $date
        if (substr($member->kode_member, 0, 6) === $date) {
            // jika ada kode member, maka kode member baru akan + 1 dari yang sebelumnya
            $kode_member = (int) substr($member->kode_member, 6) + 1;
        } else {
            //jika kosong maka kode member dimulai dari 1
            $kode_member = 1;
        }

        $member = new Member();
        $member->kode_member = $date . tambah_nol_didepan($kode_member, 4);
        $member->nama = $request->nama;
        $member->alamat = $request->alamat;
        $member->telepon = $request->telepon;
        $member->save();

        return response()->json('Data Berhasil Di Simpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::find($id);

        return response()->json($member);
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
        $member = Member::find($id);
        $member->update($request->all());

        return response()->json('Data Berhasil Di Simpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::find($id);
        $member->delete();

        return response(null, 204);
    }

    public function cetakMember(Request $request)
    {
        $datamember = collect(array());
        foreach ($request->id_member as $id) {
            $member = Member::find($id);
            $datamember[] = $member;
        }

        $datamember = $datamember->chunk(2);
        $setting = Setting::first();

        $no = 1;
        $pdf = Pdf::loadView('member.cetak', compact('datamember', 'no', 'setting'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');
        return $pdf->stream('Kartu Member.pdf');
    }
}
