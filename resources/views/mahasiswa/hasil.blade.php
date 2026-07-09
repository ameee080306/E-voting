@extends('layouts.mahasiswa')

@section('content')
<h2 class="mb-4">Hasil Pemilihan</h2>

@php
    $totalSuara = $hasil->sum('jumlah_suara');
    $winner = $hasil->first();
@endphp

<!-- CHART AND HIGHLIGHTS -->
<div class="row g-4 mb-4 align-items-stretch">
    <div class="col-lg-5">
        <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-center align-items-center">
            <div style="width: 100%; max-width: 320px; margin: 0 auto;">
                <canvas id="hasilChart"></canvas>
            </div>
            <h5 class="fw-bold mt-4 text-center">Total Suara Masuk: <span class="text-danger">{{ $totalSuara }}</span></h5>
        </div>
    </div>
    
    <div class="col-lg-7">
        <div class="row g-3">
            @foreach($hasil as $h)
            @php
                $persentase = $totalSuara > 0 ? round(($h->jumlah_suara / $totalSuara) * 100, 1) : 0;
            @endphp
            <div class="col-md-6">
                <div class="card card-custom p-3 h-100 {{ $loop->first && $totalSuara > 0 ? 'border-success border-2' : '' }}">
                    <div class="d-flex align-items-center gap-3">
                        @if($h->kandidat->foto)
                            <img src="{{ asset($h->kandidat->foto) }}" class="rounded-circle" style="width: 70px; height: 70px; object-fit:cover; border: 2px solid var(--matcha-soft);">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif
                        <div style="min-width: 0;">
                            <span class="badge bg-dark rounded-pill mb-1">Paslon {{ $h->kandidat->nomor_urut }}</span>
                            <h6 class="fw-bold mb-0 text-truncate" title="{{ $h->kandidat->nama_ketua }}">{{ $h->kandidat->nama_ketua }}</h6>
                            <small class="text-muted text-truncate d-block" title="{{ $h->kandidat->nama_wakil }}">& {{ $h->kandidat->nama_wakil }}</small>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold mb-0 text-success">{{ $persentase }}%</h4>
                        <h5 class="fw-bold mb-0">{{ $h->jumlah_suara }} <small class="text-muted fs-6">Suara</small></h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@if($winner && $totalSuara > 0)
<div class="card card-custom p-4 mb-4 text-center border-warning" style="border-width: 3px !important; background: linear-gradient(135deg, #fffcf3, #fff3cd);">
    <h4 class="fw-bold text-warning mb-3"><i class="fa-solid fa-crown"></i> Kandidat Terpilih</h4>
    @if($winner->kandidat->foto)
        <img src="{{ asset($winner->kandidat->foto) }}" class="rounded-circle mx-auto mb-3 shadow" style="width: 130px; height: 130px; object-fit:cover; border: 4px solid #ffc107;">
    @else
        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3 shadow" style="width: 130px; height: 130px; border: 4px solid #ffc107; font-size: 3rem;">
            <i class="fa-solid fa-user"></i>
        </div>
    @endif
    <h3 class="fw-bold mb-1">Paslon No. {{ $winner->kandidat->nomor_urut }}</h3>
    <h4 class="text-dark">{{ $winner->kandidat->nama_ketua }} & {{ $winner->kandidat->nama_wakil }}</h4>
    <p class="mb-0 mt-2 fs-5">Memperoleh <strong class="text-danger">{{ $winner->jumlah_suara }} Suara</strong> ({{ round(($winner->jumlah_suara / $totalSuara) * 100, 1) }}%)</p>
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        const canvas = document.getElementById('hasilChart');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const data = {
            labels: [
                @foreach($hasil as $h)
                    'Paslon {{ $h->kandidat->nomor_urut }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($hasil as $h)
                        {{ $h->jumlah_suara }},
                    @endforeach
                ],
                backgroundColor: [
                    '#4caf50', '#2196f3', '#ff9800', '#e91e63', '#9c27b0'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 14,
                                family: "'Plus Jakarta Sans', sans-serif"
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' Suara';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    })();
</script>
@endpush
