<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    protected $fillable = [
        'nama_iklan',
        'biaya',
        'biaya_pendaftaran'
    ];
}
