<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = "pengumuman";
    protected $fillable = ["id_pengumuman","user_id","id_pendaftaran","hasil_seleksi","kursus_penerima","nilai_interview","nilai_test","status"];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey= "id";

    public static function id()
    {
    	// $kode = DB::table('pengumuman')->max('id_pengumuman');
        $kode = Pengumuman::orderBy('id', 'DESC')->first();

        if ($kode) {
            $kode=$kode->id+1;
        } else {
            $kode = 1;
        }
        $digits = 1;
    	$addNol = '';
        $unique = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $waktu = now()->format('Y').$unique;
    	$kode = str_replace("ANN".$waktu, "", $kode);
    	$kode = (int) $kode + 1;
        $incrementKode = $kode;

    	if (strlen($kode) == 1) {
    		$addNol = "00";
    	} elseif (strlen($kode) == 2) {
    		$addNol = "0";
    	}
    	$kodeBaru = "ANN".$waktu.$addNol.$incrementKode;
    	return $kodeBaru;
    }

	public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
 	}
     public function kursus()
     {
         return $this->belongsTo(ProgramStudi::class, 'kursus_penerima');
      }
    public function user()
    {
         return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
