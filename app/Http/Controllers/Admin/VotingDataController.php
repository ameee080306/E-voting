<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voting;
use App\Models\PeriodePemilihan;
use App\Services\BlowfishService;

class VotingDataController extends Controller
{
    public function index()
    {
        $voting = Voting::with('user')->latest()->get();
        return view('admin.voting.index', compact('voting'));
    }
}
