<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function data()
    {
        $user = User::isNotAdmin()->orderBy('id', 'asc')->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <div class="btn-group" style="display: flex; justify-content: center;">
                    <button type="button" onclick="editForm(`' . route('user.update', $user->id) . '`)" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Edit</button>
                    <button type="button" onclick="deleteData(`' . route('user.destroy', $user->id) . '`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"> Hapus</i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->foto = '/img/user.jpg';
        $user->level = 2;
        $user->save();

        return response()->json('Data Berhasil Di Simpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = user::find($id);

        return response()->json($user);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password') && $request->password != "") {
            $user->password =  bcrypt($request->password);
        }
        $user->update();

        return response()->json('Data Berhasil Di Simpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();

        return response(null, 204);
    }

    public function profil()
    {
        $profil = auth()->user();

        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $user->name = $request->name;

        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi Password Tidak Sesuai', 422);
                }
            } else {
                return response()->json('Password Lama Tidak Sesuai', 422);
            }
        }

        if ($request->has('foto')) {
            $file = $request->file('foto');
            $nama = 'logo-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto = "/img/$nama";
        }

        $user->update();

        return response()->json($user, 200);
    }
}
