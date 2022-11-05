<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function confirm(Request $request)
    {
        if (isset($request->id)) {
             $old = Laporan::where('id', $request->id)->get()->toArray();
             if ($old[0]['status'] == '0') {
                Laporan::where('id', $request->id)->update(['status' => '1']);
             }else{
                Laporan::where('id', $request->id)->update(['status' => '0']);
             }
             return redirect('/laporan')->with('ubah', 'Data telah dikonfirmasi!');
        }else{
            return redirect('/');
        }
    }

    public function delete(Request $request)
    {
        if (isset($request->id)) {
             Laporan::where('id', $request->id)->delete();
             return redirect('/laporan')->with('ubah', 'Data telah dihapus!');
        }else{
            return redirect('/');
        }
    }

    public function index()
    {
        $kategori_laporan = ['Kehilangan ODGJ', 'Penemuan ODGJ', 'Kehilangan Tunawisma', 'Penemuan Tunawisma'];

        // API Provinsi
        $api_url = 'assets/json/provinsi.json';
        $json_data = file_get_contents($api_url);
        $provinsi = json_decode($json_data);

        //API Youtube
        $latest = HomeController::get_CURL('https://www.googleapis.com/youtube/v3/search?key=AIzaSyCvagr37XBXxWRJK6YAiyKVNYLY4oIzDUo&channelId=UCbSa4uXMTEpM3XyMZgekIRQ&maxResults=3&order=date&part=snippet');


        $profil = HomeController::get_CURL('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=UCbSa4uXMTEpM3XyMZgekIRQ&key=AIzaSyCvagr37XBXxWRJK6YAiyKVNYLY4oIzDUo');

        if (empty($id)) {
            $videoId = '2OO6osk9IZs';
        }else{
            $videoId = $latest['items'][0]['id']['videoId'];
        }

        $req = array('keyword' => request('keyword'),
                     'filter' => request('kategoriLaporan'),
                     'page' => 'lapor');
        $cari = Laporan::latest()->filter($req);
        $terbaru = Laporan::limit(3)->orderBy('id', 'DESC')->get()->toArray();

        return view('pages.lapor', [
            'title' => 'Data Laporan | Sinau Hurip',
            'aktif' => 'laporan',
            'provinsi' => $provinsi,
            'latest' => $latest,
            'profil' => $profil,
            'videoId' => $videoId,
            'kategori_laporan' => $kategori_laporan,
            'dataTerbaru' => $terbaru,
            'resultCari' => $cari
        ]);
    }

    public function  cari(Request $get)
    {
        if ($get->asal == 'ditemukan') {
            $kat = 2;
        }elseif ($get->asal == 'hilang') {
            $kat = 1;
        }elseif ($get->asal == 'laporan') {
            $kat = 'all';
        }

        if ($get->key == "") {
            $word = "";
        }else{
            $word = $get->key;
        }
        $req = array('keyword' => $word,
                     'filter' => $kat,
                     'page' => $get->asal);
        $hasil = Laporan::latest()->filter($req);
        return json_encode(['key'=>  $word, 'result'=>$hasil, 'jml' => count($hasil)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $post)
    {

        $validated = $post->validate([
            'laporan' => 'required',
            'namaPelapor' => 'required|max:100',
            'namaPasien' => 'required|max:100',
            'jenisKelamin' => 'required',
            'prov' => 'required',
            'kab' => 'required',
            'kec' => 'required',
            'desa' => 'required',
            'rincian' => 'required|max:255',
            'nomor' => 'required'
        ]);

        $aidi = laporan::count(); 
        $now = date("Y-m-d H:i:s");
        $t = explode(" ", $now);
        $tgl = explode("-", $t[0]);
        $id_lapor = $tgl[2].$tgl[1].$tgl[0].'ID'.$aidi+1;
        $alamat = $validated['desa'].",".$validated['kec'].','.$validated['kab'].','.$validated['prov'];

        if($validated){
            Laporan::insert([
            'id_laporan' => $id_lapor,
            'tgl_dibuat' => now(),
            'jenis_laporan' => $validated['laporan'],
            'nama_pelapor' => $validated['namaPelapor'],
            'nama_pasien' => $validated['namaPasien'],
            'jenis_kelamin' => $validated['jenisKelamin'],
            'alamat' => $alamat,
            'gambar' => $post->url,
            'rincian' => $validated['rincian'],
            'telepon' => $validated['nomor'],
            'status' => '0'
            ]);
            if ($post->asal == '') {
                return redirect('/')->with('success', '?keyword='.$id_lapor.'&kategoriLaporan=all&buka=1')->with('id_laporan', $id_lapor);
            }elseif ($post->asal == 'hilang'){
                return redirect('/hilang')->with('success', '?keyword='.$id_lapor.'&kategoriLaporan=all&buka=1')->with('id_laporan', $id_lapor);
            }elseif ($post->asal == 'ditemukan'){
                return redirect('/ditemukan')->with('success', '?keyword='.$id_lapor.'&kategoriLaporan=all&buka=1')->with('id_laporan', $id_lapor);
            }
            
        }else{
            return redirect('/')->with('failed', 'Laporan gagal ditambahkan!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLaporanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLaporanRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLaporanRequest  $request
     * @param  \App\Models\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLaporanRequest $request, Laporan $laporan)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laporan $laporan)
    {
        //
    }
}
