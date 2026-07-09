<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePemilihan extends Model
{
    protected $fillable = ['nama_periode', 'tanggal_mulai', 'tanggal_selesai', 'status'];}
