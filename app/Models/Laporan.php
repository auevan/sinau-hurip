<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters) 
    {
        if (isset($filters['keyword'])) {
            if ($filters['filter'] == 'all' && $filters['page'] == 'home') {
                    return Laporan::where('nama_pasien', 'like', '%'.$filters['keyword'].'%')->orwhere('id_laporan', 'like', '%'.$filters['keyword'].'%')->orderBy('tgl_dibuat', 'ASC')->get()->toArray();
                }elseif($filters['filter'] == 1){
                    return Laporan::where('nama_pasien', 'like', '%'.$filters['keyword'].'%')->where(function($q) {
                             $q->where('jenis_laporan', '1')
                               ->orWhere('jenis_laporan', '3');
                         })->where('status', '1')->orderBy('tgl_dibuat', 'ASC')->get()->toArray();
                    
                }elseif($filters['filter'] == 2){
                    return Laporan::where('nama_pasien', 'like', '%'.$filters['keyword'].'%')->where(function($q) {
                             $q->where('jenis_laporan', '2')
                               ->orWhere('jenis_laporan', '4');
                         })->where('status', '1')->orderBy('tgl_dibuat', 'ASC')->get()->toArray();
                    
                }elseif ($filters['filter'] == 'all' && $filters['page'] == 'laporan') {
                    return Laporan::where('nama_pasien', 'like', '%'.$filters['keyword'].'%')->orwhere('id_laporan', 'like', '%'.$filters['keyword'].'%')->orderBy('tgl_dibuat', 'ASC')->get()->toArray();
                }else{
                    return array();
                }
        }else{
            if ($filters['page'] == 'home') {
                return '';
            }elseif ($filters['page'] == 'hilang'){
                return Laporan::where('status', '1')->where(function($q) {
                             $q->where('jenis_laporan', '1')
                               ->orWhere('jenis_laporan', '3');
                         })->orderBy('tgl_dibuat', 'ASC')->paginate(5)->withQueryString();
            }elseif ($filters['page'] == 'ditemukan'){
                return Laporan::where('status', '1')->where(function($q) {
                             $q->where('jenis_laporan', '2')
                               ->orWhere('jenis_laporan', '4');
                         })->orderBy('tgl_dibuat', 'ASC')->paginate(5)->withQueryString();
            }elseif ($filters['page'] == 'lapor'){
                return Laporan::orderBy('status', 'ASC')->orderBy('id', 'DESC')->paginate(5)->withQueryString();
            }
        }
    }

    use HasFactory;
}
