<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $table = "perizinan";
    protected $fillable = ['id','nama','email','judul','tanggal_mulai_izin','tanggal_berakhir_izin','catatan','status','catatan_penolakan','total_hari'];
}
