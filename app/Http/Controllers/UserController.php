<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use DB;
use App\Models\User;
use App\Models\Gaji;
use App\Models\Absen;
use App\Models\Jabatan;
use App\Models\Potongan;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index() {
        $title = "Home";
        $gaji = Gaji::where('user_id', Auth::user()->id)->get();
        return view('karyawan.index', compact('title','gaji'));
    }
    public function profile()
    {
        $title = 'Profile';
        $karyawan = User::find(Auth::user()->id);
        return view('karyawan.profile', compact('title','karyawan'));
    }
    public function updateProfile(Request $request){
        DB::beginTransaction();
        try {
            if (empty($request->password)) {
                $user = User::find($request->id);
                $user->nip = $request->nip;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->no_hp = $request->no_hp;
                $user->jk = $request->jk;
                $user->save();
            }else {
                $user = User::find($request->id);
                $user->nip = $request->nip;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->no_hp = $request->no_hp;
                $user->jk = $request->jk;
                $user->password = bcrypt($request->password);
                $user->save();
            }
             DB::commit();
            \Session::flash('msg_success','Profile Berhasil Diubah!');
            return Redirect::route('karyawan.profile');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('karyawan.profile');
        }
    }
    public function gaji() {
        $gaji = Gaji::where('user_id', Auth::user()->id)->get();
        $title = "Data Gaji";
        return view('karyawan.gaji', compact('title','gaji'));
    }
}
