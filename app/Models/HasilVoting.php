<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilVoting extends Model
{
    protected $fillable = ['kandidat_id', 'jumlah_suara'];

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }}
