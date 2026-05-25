<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    private function getToko()
    {
        return Toko::where('user_id', Auth::id())->first();
    }

    public function update(Request $request)
    {
        $tokoSession = $this->getToko();

        $request->validate([
            'username'       => 'required|min:3|max:30|unique:users,username,' . $tokoSession->user->id,
            'nama'           => 'required|min:3|max:50',
            'nama_toko'      => 'required|min:3|max:50|unique:tokos,nama_toko,' . $tokoSession->id,
            'email'          => 'required|email|unique:users,email,' . $tokoSession->user->id,
            'hp'             => 'required|digits_between:10,13',
            'provinsi_id'    => 'nullable|required_with:kota_id,kecamatan_id',
            'kota_id'        => 'nullable|required_with:provinsi_id,kecamatan_id',
            'kecamatan_id'   => 'nullable|required_with:provinsi_id,kota_id',
            'deskripsi_toko' => 'nullable|min:10|max:255',
            'foto_toko'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $tokoSession->user->update([
            'username' => $request->username,
            'name'     => $request->nama,
            'email'    => $request->email,
            'hp'       => $request->hp,
        ]);

        if ($request->hasFile('foto_toko')) {
            if ($tokoSession->foto_toko) {

                Storage::disk('public')
                    ->delete($tokoSession->foto_toko);
            }
            $fotoPath = $request->file('foto_toko')
                ->store('foto-toko', 'public');

            $tokoSession->foto_toko = $fotoPath;
        }
        $tokoSession->update([
            'nama_toko'    => $request->nama_toko,
            'provinsi_id'  => $request->provinsi_id,
            'kota_id'      => $request->kota_id,
            'kecamatan_id' => $request->kecamatan_id,
            'deskripsi'    => $request->deskripsi_toko,
        ]);

        $tokoSession->save();

        return redirect()
        ->route('seller.dashboard')
        ->with(
            'success',
            'Data toko berhasil diperbarui'
        );
    }

    public function destroy(string $id)
    {
        //
    }
}
