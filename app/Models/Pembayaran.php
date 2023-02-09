<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// use DB;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = "pembayaran";
    protected $fillable = ["id_pembayaran","bukti_pembayaran","status","verifikasi","tgl_pembayaran","id_pendaftaran"];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey= "id";

	public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
 	}
    public static function id()
    {
    	// $kode = DB::table('pembayaran')->max('id_pembayaran');
        
        $kode = Pembayaran::orderBy('id', 'DESC')->first();

		if ($kode) {
            $kode=$kode->id+1;
        } else {
            $kode = 1;
        }
        $digits = 1;
    	$addNol = '';
        $unique = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $waktu = now()->format('Y').$unique;
    	$kode = str_replace("PAY".$waktu, "", $kode);
    	$kode = (int) $kode + 1;
        $incrementKode = $kode;

    	if (strlen($kode) == 1) {
    		$addNol = "000";
    	} elseif (strlen($kode) == 2) {
    		$addNol = "00";
    	} elseif (strlen($kode) == 3) {
    		$addNol = "0";
        }
    	$kodeBaru = "PAY".$waktu.$addNol.$incrementKode;
    	return $kodeBaru;
    }
}
