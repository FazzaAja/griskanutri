@extends('layouts.app')

{{-- Set judul untuk halaman ini --}}
@section('title', 'Dashboard')

{{-- Mulai bagian konten --}}
@section('content')
    <div class="content-header">
        <h4 class="title is-4">Dashboard</h4>
        <span class="separator"></span>
        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
            <ul>
                <li><a href="#">General</a></li>
                <li class="is-active"><a href="#" aria-current="page">Dashboard</a></li>
            </ul>
        </nav>
    </div>

    <div class="content-body">
        {{-- KODE BARU untuk 4 kartu statistik dinamis --}}
        <div class="columns">
            {{-- Card Total Pengguna --}}
            <div class="column">
                <div class="box quick-stats has-background-info has-text-white">
                    <div class="quick-stats-icon">
                        <span class="icon is-large"><i class="fa fa-3x fa-users"></i></span>
                    </div>
                    <div class="quick-stats-content">
                        <p class="title is-1 has-text-white">{{ $userCount }}</p>
                        <p class="subtitle is-5 has-text-white">Total Pengguna</p>
                    </div>
                </div>
            </div>

            {{-- Card Total Materi --}}
            <div class="column">
                <div class="box quick-stats has-background-success has-text-white">
                    <div class="quick-stats-icon">
                        <span class="icon is-large"><i class="fa fa-3x fa-book"></i></span>
                    </div>
                    <div class="quick-stats-content">
                        <p class="title is-1 has-text-white">{{ $materiCount }}</p>
                        <p class="subtitle is-5 has-text-white">Total Materi</p>
                    </div>
                </div>
            </div>

            {{-- Card Total Soal --}}
            <div class="column">
                <div class="box quick-stats has-background-warning has-text-white">
                    <div class="quick-stats-icon">
                        <span class="icon is-large"><i class="fa fa-3x fa-question-circle"></i></span>
                    </div>
                    <div class="quick-stats-content">
                        <p class="title is-1 has-text-white">{{ $soalCount }}</p>
                        <p class="subtitle is-5 has-text-white">Total Soal</p>
                    </div>
                </div>
            </div>

            {{-- Card Total Resep --}}
            <div class="column">
                <div class="box quick-stats has-background-danger has-text-white">
                    <div class="quick-stats-icon">
                        <span class="icon is-large"><i class="fa fa-3x fa-utensils"></i></span>
                    </div>
                    <div class="quick-stats-content">
                        <p class="title is-1 has-text-white">{{ $resepCount }}</p>
                        <p class="subtitle is-5 has-text-white">Total Resep</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
{{-- Akhir bagian konten --}}

{{-- Mulai bagian scripts tambahan --}}
@push('scripts')
<script>
    // Script ini hanya akan di-load di halaman dashboard
    $(document).ready(function() {
        let bar = {
            type: 'bar',
            height: 40,
            barWidth: 4,
            barColor: '#fff',
            barSpacing: 3
        };

        let line = {
            type: 'line',
            width: 150,
            height: 36,
            lineColor: '#fff',
            fillColor: 'rgba(0,0,0,0)',
            lineWidth: 2,
            maxSpotColor: 'rgba(255,255,255,0.4)',
            minSpotColor: 'rgba(255,255,255,0.4)',
            spotColor: 'rgba(255,255,255,0.4)',
            spotRadius: 3,
            highlightSpotColor: '#fff',
            highlightLineColor: 'rgba(255,255,255,0.4)'
        };

        function data(length = 22) {
            return Array.from({length}, () => Math.floor(Math.random() * 40));
        }

        $('.inlinesparkline-bar').each(function() {
            $(this).sparkline(data(), bar);
        });

        $('.inlinesparkline-line').each(function() {
            $(this).sparkline(data(), line);
        });

        var ctx1 = document.getElementById('chart2').getContext('d');
        window.myBar = new Chart(ctx1, {
            type: 'bar',
            data: {
                "labels": ["January", "February", "March", "April", "May", "June", "July"],
                "datasets": [{
                    "label": "Dataset 1",
                    "backgroundColor": "rgb(255, 99, 132)",
                    "stack": "Stack 0",
                    "data": data(8)
                }, {
                    "label": "Dataset 2",
                    "backgroundColor": "rgb(54, 162, 235)",
                    "stack": "Stack 0",
                    "data": data(8)
                }, {
                    "label": "Dataset 3",
                    "backgroundColor": "rgb(75, 192, 192)",
                    "stack": "Stack 1",
                    "data": data(8)
                }]
            },
            options: {
                title: { display: false },
                tooltips: { mode: 'index', intersect: false },
                responsive: true,
                scales: {
                    x: { stacked: true },
                    y: { stacked: true }
                },
                legend: { display: false },
            }
        });

        var ctx2 = document.getElementById('chart1').getContext('2d');
        window.myLine = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"],
                datasets: [{
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: data(8),
                    label: 'Dataset',
                    fill: 'start'
                }]
            },
            options: {
                title: { display: false },
                legend: { display: false },
            }
        });
    });
</script>
@endpush
{{-- Akhir bagian scripts --}}
