<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaPendaftaran extends Model
{
    protected $fillable = [
        'user_id',
        'kalangan_id',
        'iklan_id',
        'webinar_id',
        'nama_peserta',
        'nama_kalangan',
        'nama_iklan',
        'nama_webinar',
        'biaya_pendaftaran'
    ];
}
