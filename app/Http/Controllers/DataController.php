<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataController extends Controller
{
    public function updateData(String $id, Request $request) {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'nama' => 'required|string',
            'email' => ['required','email',Rule::unique('users')->ignore($user->id)],
            'nomor_hp' => 'required',
            'alamat' => 'required',
        ]);

        try {
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'alamat' => $request->alamat,
            ]);
    
            return redirect('data-pribadi')->with('success','Data Berhasil di Perbaharui');
        } catch (Exception $e) {
            return redirect('data-pribadi')->with('error','Data Gagal di Perbaharui');
        }
    }
}
