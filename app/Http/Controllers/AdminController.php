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

class AdminController extends Controller
{
    public function index() {
        $title = "Home";
        $jabatan = Jabatan::all();
        $potongan = Potongan::all();
        $karyawan = User::where('role','Karyawan')->get();
        $gaji = Gaji::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->get();
        return view('admin.index', compact('title','gaji','potongan','jabatan','karyawan'));
    }
    public function profile()
    {
        $title = 'Profile';
        $admin = User::find(Auth::user()->id);
        return view('admin.profile', compact('title','admin'));
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
            return Redirect::route('admin.profile');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.profile');
        }
    }
    public function karyawan() {
        $title = "Data Karyawan";
        $karyawan = User::where('role','Karyawan')->get();
        $jabatan = Jabatan::all();
        return view('admin.karyawan', compact('title','karyawan','jabatan'));
    }
    public function addKaryawan(Request $request)
    {
        // return $request;
       DB::beginTransaction();
        try {
            $user = new User;
            $user->nip = $request->nip;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->no_hp = $request->no_hp;
            $user->jk = $request->jk;
            $user->jabatan_id = $request->jabatan_id;
            $user->password = bcrypt($request->password);
            $user->role = 'Karyawan';
            $user->save();

             DB::commit();
            \Session::flash('msg_success','Karyawan Berhasil Ditambah!');
            return Redirect::route('admin.karyawan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.karyawan');
        }
    }
    public function updateKaryawan(Request $request)
    {
       DB::beginTransaction();
        try {
            if (empty($request->password)) {
                $user = User::find($request->id);
                $user->nip = $request->nip;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->no_hp = $request->no_hp;
                $user->jk = $request->jk;
                $user->jabatan_id = $request->jabatan_id;
                $user->save();
            }else {
                $user = User::find($request->id);
                $user->nip = $request->nip;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->no_hp = $request->no_hp;
                $user->jk = $request->jk;
                $user->jabatan_id = $request->jabatan_id;
                $user->password = bcrypt($request->password);
                $user->save();
            }
             DB::commit();
            \Session::flash('msg_success','Karyawan Berhasil Diubah!');
           return Redirect::route('admin.karyawan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
           return Redirect::route('admin.karyawan');
        }
    }
    public function deleteKaryawan($id)
    {
        DB::beginTransaction();
        try {
            $karyawan = User::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data Karyawan Berhasil Dihapus!');
            return Redirect::route('admin.karyawan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.karyawan');
        }
    }
    public function jabatan() {
        $jabatan = Jabatan::all();
        $title = "Data Jabatan";
        return view('admin.jabatan', compact('title','jabatan'));
    }
    public function addJabatan(Request $request)
    {
        // return $request;
       DB::beginTransaction();
        try {
            $jabatan = new Jabatan;
            $jabatan->name = $request->name;
            $jabatan->gaji = $request->gaji;
            $jabatan->tunjangan = $request->tunjangan;
            $jabatan->uang_makan = $request->uang_makan;
            $jabatan->save();

             DB::commit();
            \Session::flash('msg_success','Jabatan Berhasil Ditambah!');
            return Redirect::route('admin.jabatan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.jabatan');
        }
    }
    public function updateJabatan(Request $request)
    {
       DB::beginTransaction();
        try {
                $jabatan = Jabatan::find($request->id);
                $jabatan->name = $request->name;
                $jabatan->gaji = $request->gaji;
                $jabatan->tunjangan = $request->tunjangan;
                $jabatan->uang_makan = $request->uang_makan;
                $jabatan->save();

             DB::commit();
            \Session::flash('msg_success','Jabatan Berhasil Diubah!');
           return Redirect::route('admin.jabatan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
           return Redirect::route('admin.jabatan');
        }
    }
    public function deleteJabatan($id)
    {
        DB::beginTransaction();
        try {
            $jabatan = Jabatan::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data Jabatan Berhasil Dihapus!');
            return Redirect::route('admin.jabatan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.jabatan');
        }
    }
    public function absen() {
        $user = User::where('role','Karyawan')->get();
        $absen = Absen::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->get();
        $title = "Data Absen";
        return view('admin.absen', compact('title','user','absen'));
    }
    public function addAbsen()
    {
       DB::beginTransaction();
        try {
            $user = User::where('role','Karyawan')->get();
            foreach ($user as $key => $value) {
                $cekAbsen = Absen::where('user_id', $value->id)->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->first();
                if (empty($cekAbsen)) {
                    $absen = new Absen;
                    $absen->user_id = $value->id;
                    $absen->izin = null;
                    $absen->sakit = null;
                    $absen->alpha = null;
                    $absen->is_submit = 0;
                    $absen->save();
                }else{

                }
            }
             DB::commit();
            \Session::flash('msg_success','Absen Berhasil Ditambah!');
            return Redirect::route('admin.absen');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.absen');
        }
    }
    public function updateAbsen(Request $request)
    {
       DB::beginTransaction();
        try {
                $absen = Absen::find($request->id);
                $absen->izin = $request->izin;
                $absen->sakit = $request->sakit;
                $absen->alpha = $request->alpha;
                $absen->is_submit = 1;
                $absen->save();

                $potonganIzin = Potongan::where('name','Izin')->first();
                $potonganSakit = Potongan::where('name','Sakit')->first();
                $potonganAlpha = Potongan::where('name','Alpha')->first();

                $totalPotonganIzin = $potonganIzin->potongan * $request->izin;
                $totalPotonganSakit = $potonganSakit->potongan * $request->sakit;
                $totalPotonganAlpha = $potonganAlpha->potongan * $request->alpha;

                $totalPotongan = $totalPotonganIzin + $totalPotonganSakit + $totalPotonganAlpha;
                $cekUser = User::find($absen->user_id);

                $totalGaji = ($cekUser->Jabatan->gaji + $cekUser->Jabatan->tunjangan + $cekUser->Jabatan->uang_makan ) - $totalPotongan;

                $gaji = new Gaji;
                $gaji->user_id = $absen->user_id;
                $gaji->absen_id = $absen->id;
                $gaji->potongan = $totalPotongan;
                $gaji->total_gaji = $totalGaji;
                $gaji->save();

             DB::commit();
            \Session::flash('msg_success','Absen Berhasil Diubah!');
           return Redirect::route('admin.absen');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
           return Redirect::route('admin.absen');
        }
    }
    public function potongan() {
        $potongan = Potongan::all();
        $title = "Data Potongan";
        return view('admin.potongan', compact('title','potongan'));
    }
    public function addPotongan(Request $request)
    {
        // return $request;
       DB::beginTransaction();
        try {
            $cekPotongan = Potongan::where('name',$request->name)->first();
            if (!empty($cekPotongan)) {
                \Session::flash('msg_error','Potongan sudah ada!');
                return Redirect::route('admin.potongan');
            }
            $potongan = new Potongan;
            $potongan->name = $request->name;
            $potongan->potongan = $request->potongan;
            $potongan->save();

             DB::commit();
            \Session::flash('msg_success','Potongan Berhasil Ditambah!');
            return Redirect::route('admin.potongan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.potongan');
        }
    }
    public function updatePotongan(Request $request)
    {
       DB::beginTransaction();
        try {
                $potongan = Potongan::find($request->id);
                $potongan->name = $request->name;
                $potongan->potongan = $request->potongan;
                $potongan->save();

             DB::commit();
            \Session::flash('msg_success','Potongan Berhasil Diubah!');
           return Redirect::route('admin.potongan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
           return Redirect::route('admin.potongan');
        }
    }
    public function deletePotongan($id)
    {
        DB::beginTransaction();
        try {
            $potongan = Potongan::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data Potongan Berhasil Dihapus!');
            return Redirect::route('admin.potongan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.potongan');
        }
    }
    public function gaji() {
        $gaji = Gaji::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->get();
        $title = "Data Gaji";
        return view('admin.gaji', compact('title','gaji'));
    }
    function pdfGaji(Request $request)
    {
        $tahun = date('Y');
        $tanggal = $tahun.'-'.$request->bulan.'-'.'01';
        $gaji = Gaji::whereMonth('created_at',$request->bulan)->whereYear('created_at',date('Y'))->get();
        $pdf = Pdf::loadView('admin.pdfGaji', compact('gaji','tanggal'))->setPaper('a4','landscape');
        return $pdf->stream();
    }
}
