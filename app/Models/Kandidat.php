<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $fillable = ['nomor_urut', 'nama_ketua', 'nama_wakil', 'foto', 'visi', 'misi'];

    public function hasilVoting()
    {
        return $this->hasOne(HasilVoting::class);
    }}
