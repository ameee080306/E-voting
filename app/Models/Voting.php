<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    protected $fillable = ['user_id', 'suara_terenkripsi', 'waktu_memilih'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }}
