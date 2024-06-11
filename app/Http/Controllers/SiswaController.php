<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class SiswaController extends Controller
{


	// Login
	public function showLoginForm()
	{
		return view('login');
	}

	public function login(Request $request)
	{
		$credentials = $request->only('username', 'password');

		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();

			// Arahkan pengguna berdasarkan peran mereka
			if (Auth::user()->role == 'admin') {
				return redirect()->intended('/datasiswa');
			} elseif (Auth::user()->role == 'user') {
				return redirect()->intended('/user/index');
			} else {
				Auth::logout();
				return redirect('/login')->with('failed', 'Role tidak dikenali.');
			}
		}

		return back()->withErrors([
			'username' => 'Data tidak sesuai.',
		]);
	}

	public function showRegisterForm()
	{
		return view('register');
	}

	public function register(Request $request)
	{
		$request->validate([
			'username' => 'required|string|max:255|unique:users',
			'password' => 'required|string|min:8|confirmed',
			'role' => 'required|string|in:admin,user',
		]);

		$user = User::create([
			'username' => $request->username,
			'password' => Hash::make($request->password),
			'role' => $request->role,
		]);

		Auth::login($user);

		return redirect('/login')->with('success', 'Registrasi berhasil');
	}

	public function logout(Request $request)
	{
		Auth::logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect('/login');
	}

	// Profile
	public function profile()
	{
		$user = Auth::user(); // Mengambil data pengguna yang sedang login
		return view('profile', ['user' => $user]);
	}

	//print

	public function print()
	{
		$print = DB::table('siswa')->orderBy('Absen', 'asc')->get();
		$pdf = PDF::loadView('print', ["print" => $print]);
		return $pdf->stream('datasiswa.pdf');
	}

	// index
	public function index()
	{
		return view('user.index');
	}

	//user data siswa

	public function userdatasiswa()
	{
		$siswa = DB::table('siswa')->orderBy('Absen', 'asc')->get();

		return view('user.datasiswa', ['siswa' => $siswa]);
	}


	// data siswa

	public function datasiswa()
	{
		$siswa = DB::table('siswa')->orderBy('Absen', 'asc')->get();

		return view('datasiswa', ['siswa' => $siswa]);
	}


	//tambah data siswa 

	public function tambah()
	{
		$opt = DB::table('kelas')->select('kelas', 'nama_kelas')->get();
		return view('tambah', ['opt' => $opt]);
	}
	public function store(Request $request)
	{
		DB::table('siswa')->insert([
			'NISN' => $request->NISN,
			'absen' => $request->absen,
			'Nama' => $request->Nama,
			'kelas' => $request->kelas
		]);
		return redirect('datasiswa');
	}

	//user cari data siswa

	public function usercari(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;

		// mengambil data dari table pegawai sesuai pencarian data
		$cari = DB::table('siswa')
			->where('Nama', 'like', "%" . $cari . "%")
			->paginate();

		// mengirim data pegawai ke view index
		return view('user.datasiswa', ['siswa' => $cari]);
	}

	//user cari data tugas

	public function usercaritugas(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;

		// mengambil data dari table pegawai sesuai pencarian data
		$cari = DB::table('tugas')
			->where('Nama_Siswa', 'like', "%" . $cari . "%")
			->paginate();

		// mengirim data pegawai ke view index
		return view('user.datapengumpulan', ['tugas' => $cari]);
	}

	//cari data siswa

	public function cari(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;

		// mengambil data dari table pegawai sesuai pencarian data
		$cari = DB::table('siswa')
			->where('Nama', 'like', "%" . $cari . "%")
			->paginate();

		// mengirim data pegawai ke view index
		return view('/datasiswa', ['siswa' => $cari]);
	}

	// hapus data siswa

	public function hapus($id)
	{
		DB::table('siswa')->where('NISN', $id)->delete();

		return redirect('datasiswa');
	}

	// edit siswa

	public function editsiswa($id)
	{
		$opt = DB::table('kelas')->select('kelas', 'nama_kelas')->get();
		$siswa = DB::table('siswa')->where('NISN', $id)->get();
		return view('edit', ['siswa' => $siswa, 'opt' => $opt]);
	}

	public function update(Request $request)
	{
		DB::table('siswa')->where('NISN', $request->id)->update([
			'absen' => $request->absen,
			'Nama' => $request->Nama,
			'kelas' => $request->kelas
		]);

		return redirect('datasiswa');
	}

	//user data tugas

	public function userdatatugas()
	{
		$tugas = DB::table('tugas')->orderBy('No_Absen', 'asc')->get();

		return view('user.datapengumpulan', ['tugas' => $tugas]);
	}

	// data pengumpulan

	public function datapengumpulan()
	{
		$pengumpulan = DB::table('pengumpulan')->orderBy('No_Absen', 'asc')->get();

		return view('datapengumpulan', ['pengumpulan' => $pengumpulan]);
	}


	// print pengumpulan

	public function printpengumpulan()
	{
		$printpengumpulan = DB::table('pengumpulan')->orderBy('No_Absen', 'asc')->get();
		$pdf = PDF::loadView('printpengumpulan', ["printpengumpulan" => $printpengumpulan]);
		return $pdf->stream('datapengumpulan.pdf');
	}

	//cari pengumpulan

	public function caripengumpulan(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;

		// mengambil data dari table pegawai sesuai pencarian data
		$cari = DB::table('pengumpulan')
			->where('Nama_Siswa', 'like', "%" . $cari . "%")
			->orWhere('Nama_Mapel', 'like', "%" . $cari . "%")
			->orWhere('Nama_Tugas', 'like', "%" . $cari . "%")
			->paginate();


		// mengirim data pegawai ke view index
		return view('/datapengumpulan', ['pengumpulan' => $cari]);
	}


	// tambah pengumpulan

	public function tambahpengumpulan()
	{

		return view('tambahpengumpulan');
	}
	public function storepengumpulan(Request $request)
	{
		DB::table('pengumpulan')->insert([
			'Nama_Siswa' => $request->NAMA,
			'No_Absen' => $request->ABSEN,
			'Nama_Mapel' => $request->MAPEL,
			'Nama_Tugas' => $request->TUGAS,
			'Tanggal_pengumpulan' => $request->TANGGAL
		]);
		return redirect('datapengumpulan');
	}


	// edit pengumpulan

	public function editpengumpulan($id)
	{
		$pengumpulan = DB::table('pengumpulan')->where('id_pengumpulan', $id)->get();
		return view('editpengumpulan', ['pengumpulan' => $pengumpulan]);
	}

	public function updatepengumpulan(Request $request)
	{

		DB::table('pengumpulan')->where('id_pengumpulan', $request->id)->update([
			'Nama_Siswa' => $request->Nama_Siswa,
			'No_Absen' => $request->No_Absen,
			'Nama_Mapel' => $request->Nama_Mapel,
			'Nama_Tugas' => $request->Nama_Tugas,
			'Tanggal_pengumpulan' => $request->Tanggal_pengumpulan
		]);

		return redirect('datapengumpulan');
	}

	// hapus data pengumpulan

	public function hapuspengumpulan($id)
	{
		DB::table('pengumpulan')->where('id_pengumpulan', $id)->delete();

		return redirect('datapengumpulan');
	}


	//user data tugas

	public function usertambahtugas()
	{

		return view('user.tambahtugas');
	}

	//user tambah tugas

	public function userstoretugas(Request $request)
	{

		$file = $request->file('gambar');
		$nama_file = time() . "_" . $file->getClientOriginalName();
		$tempat = 'img';
		$file->move($tempat, $nama_file);

		DB::table('tugas')->insert([
			'Nama_Siswa' => $request->NAMA,
			'No_Absen' => $request->ABSEN,
			'Nama_Mapel' => $request->MAPEL,
			'Nama_Tugas' => $request->TUGAS,
			'Pengumpulan' => $nama_file
		]);
		return redirect('user/tambahtugas');
	}


	// data tugas

	public function datastugas()
	{
		$tugas = DB::table('tugas')->orderBy('No_Absen', 'asc')->get();

		return view('datatugas', ['tugas' => $tugas]);
	}

	// print tugas

	public function printtugas()
	{
		$printtugas = DB::table('tugas')->orderBy('No_Absen', 'asc')->get();
		$pdf = PDF::loadView('printtugas', ["printtugas" => $printtugas]);
		return $pdf->stream('datatugas.pdf');
	}

	//cari data tugas

	public function caritugas(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;

		// mengambil data dari table pegawai sesuai pencarian data
		$cari = DB::table('tugas')
			->where('Nama_Siswa', 'like', "%" . $cari . "%")
			->orWhere('Nama_Mapel', 'like', "%" . $cari . "%")
			->orWhere('Nama_Tugas', 'like', "%" . $cari . "%")
			->paginate();

		// mengirim data pegawai ke view index
		return view('/datatugas', ['tugas' => $cari]);
	}

	// hapus data tugas

	public function hapustugas($id)
	{
		DB::table('tugas')->where('id_tugas', $id)->delete();

		return redirect('datatugas');
	}

	//cari kelas

	public function carikelas(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;

		// mengambil data dari table pegawai sesuai pencarian data
		$cari = DB::table('kelas')
			->where('nama_kelas', 'like', "%" . $cari . "%")
			->paginate();

		// mengirim data pegawai ke view index
		return view('/datakelas', ['kelas' => $cari]);
	}

	// print pengumpulan

	public function printkelas()
	{
		$printkelas = DB::table('kelas')->get();
		$pdf = PDF::loadView('printkelas', ["printkelas" => $printkelas]);
		return $pdf->stream('datakelas.pdf');
	}

	// data kelas

	public function datakelas()
	{
		$kelas = DB::table('kelas')->orderBy('kelas', 'desc')->get();

		return view('datakelas', ['kelas' => $kelas]);
	}

	// tambah kelas

	public function tambahkelas()
	{
		$kelas = DB::table('kelas')->get();

		return view('tambahkelas', ['kelas' => $kelas]);
	}

	public function storekelas(Request $request)
	{
		DB::table('kelas')->insert([
			'nama_kelas' => $request->nama_kelas,
		]);
		return redirect('datakelas');
	}

	// hapus data kelas

	public function hapuskelas($id)
	{
		DB::table('kelas')->where('kelas', $id)->delete();

		return redirect('datakelas');
	}
}
