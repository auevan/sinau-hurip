<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

 
class HomeController extends Controller
{

    public static function get_CURL($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    public static function crop(Request $request){
        $validated = $request->validate([
            'gambar' => 'required|file|max:2000'
        ]);

        $directory = getcwd()."/assets/tmp/";
 
        $j = 0;
         
        $files2 = glob( $directory ."*" );
         
        if( $files2 ) {
            $j = count($files2);
        }

        $jml = $j+1;
        $nama = "tmp_".$jml;
        $file = $request->file('gambar');

        if ($validated) {
            if ($request->gambar->isValid()) {
                if (!file_exists('assets/tmp/'.$nama.'.jpg')) {
                    $tujuan_upload = 'assets/tmp/';
                    $file->move($tujuan_upload, $nama.'.jpg');
                    return response()->json(['status'=>1, 'msg'=> $nama]);
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('loginSuccess', 'Selamat Datang');
        }

        return back()->with('loginError', 'Username dan password tidak sesuai!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('logout', 'Berhasil Logout!');
    }


    public static function index()
    {
        
        $kategori_laporan = ['Kehilangan ODGJ', 'Penemuan ODGJ', 'Kehilangan Tunawisma', 'Penemuan Tunawisma'];

        // API Provinsi
        $api_url = 'assets/json/provinsi.json';
        $json_data = file_get_contents($api_url);
        $provinsi = json_decode($json_data);

        //API Youtube
        $latest = self::get_CURL('https://www.googleapis.com/youtube/v3/search?key=AIzaSyCvagr37XBXxWRJK6YAiyKVNYLY4oIzDUo&channelId=UCbSa4uXMTEpM3XyMZgekIRQ&maxResults=3&order=date&part=snippet');


        $profil = self::get_CURL('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=UCbSa4uXMTEpM3XyMZgekIRQ&key=AIzaSyCvagr37XBXxWRJK6YAiyKVNYLY4oIzDUo');
        $req = array('keyword' => request('keyword'),
                     'filter' => request('kategoriLaporan'),
                     'page' => 'home');
        $cari = Laporan::latest()->filter($req);


        if (empty($id)) {
            $videoId = '2OO6osk9IZs';
        }else{
            $videoId = $latest['items'][0]['id']['videoId'];
        }
        $terbaru = Laporan::limit(3)->where('status', '1')->orderBy('id', 'DESC')->get()->toArray();

        return view('pages.home', [
            'title' => 'Beranda | Sinau Hurip',
            'aktif' => 'beranda',
            'provinsi' => $provinsi,
            'latest' => $latest,
            'profil' => $profil,
            'videoId' => $videoId,
            'kategori_laporan' => $kategori_laporan,
            'dataTerbaru' => $terbaru,
            'hasilCari' => $cari
        ]);
    }

    public static function hilang()
    {
        $kategori_laporan = ['Kehilangan ODGJ', 'Penemuan ODGJ', 'Kehilangan Tunawisma', 'Penemuan Tunawisma'];

        // API Provinsi
        $api_url = 'assets/json/provinsi.json';
        $json_data = file_get_contents($api_url);
        $provinsi = json_decode($json_data);

        //API Youtube
        $latest = self::get_CURL('https://www.googleapis.com/youtube/v3/search?key=AIzaSyCvagr37XBXxWRJK6YAiyKVNYLY4oIzDUo&channelId=UCbSa4uXMTEpM3XyMZgekIRQ&maxResults=3&order=date&part=snippet');


        $profil = self::get_CURL('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=UCbSa4uXMTEpM3XyMZgekIRQ&key=AIzaSyCvagr37XBXxWRJK6YAiyKVNYLY4oIzDUo');

        if (empty($id)) {
            $videoId = '2OO6osk9IZs';
        }else{
            $videoId = $latest['items'][0]['id']['videoId'];
        }

        $req = array('keyword' => request('keyword'),
                     'filter' => request('kategoriLaporan'),
                     'page' => 'hilang');
        $cari = Laporan::latest()->filter($req);
        $terbaru = Laporan::limit(3)->orderBy('id', 'DESC')->get()->toArray();

        return view('pages.hilang', [
            'title' => 'Data Hilang | Sinau Hurip',
            'aktif' => 'hilang',
            'provinsi' => $provinsi,
            'latest' => $latest,
            'profil' => $profil,
            'videoId' => $videoId,
            'kategori_laporan' => $kategori_laporan,
            'dataTerbaru' => $terbaru,
            'resultCari' => $cari
        ]);

    }
    public static function ditemukan()
    {
        $kategori_laporan = ['Kehilangan ODGJ', 'Penemuan ODGJ', 'Kehilangan Tunawisma', 'Penemuan Tunawisma'];
        
        // API Provinsi
        $api_url = 'assets/json/provinsi.json';
        $json_data = file_get_contents($api_url);
        $provinsi = json_decode($json_data);

        //API Youtube
        $latest = self::get_CURL('https://www.googleapis.com/youtube/v3/search?key=AIzaSyCvagr37XBXxWRJK6YAiyKVNYLY4oIzDUo&channelId=UCbSa4uXMTEpM3XyMZgekIRQ&maxResults=3&order=date&part=snippet');


        $profil = self::get_CURL('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=UCbSa4uXMTEpM3XyMZgekIRQ&key=AIzaSyCvagr37XBXxWRJK6YAiyKVNYLY4oIzDUo');

        if (empty($id)) {
            $videoId = '2OO6osk9IZs';
        }else{
            $videoId = $latest['items'][0]['id']['videoId'];
        }

        $req = array('keyword' => request('keyword'),
                     'filter' => request('kategoriLaporan'),
                     'page' => 'ditemukan');
        $cari = Laporan::latest()->filter($req);
        $terbaru = Laporan::limit(3)->orderBy('id', 'DESC')->get()->toArray();
        
        return view('pages.ditemukan', [
            'title' => 'Data Ditemukan | Sinau Hurip',
            'aktif' => 'ditemukan',
            'provinsi' => $provinsi,
            'latest' => $latest,
            'profil' => $profil,
            'videoId' => $videoId,
            'kategori_laporan' => $kategori_laporan,
            'dataTerbaru' => $terbaru,
            'resultCari' => $cari
        ]);    
    }

}
