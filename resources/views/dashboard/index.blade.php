@extends('layouts.app')
@section('page-header')
<div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Dashboard</h1>
                        <p>Ringkasan stok barang, transaksi persediaan, dan kondisi barang saat ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="iq-header-img">
        <img src="{{ asset('hope-ui/assets/images/dashboard/top-header.jpg') }}"
            alt="header"
            class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid content-inner mt-n5 py-0">
    {{-- Summary Card --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-secondary">Total Barang</p>
                            <h3 class="mb-0">{{ number_format($totalProducts) }}</h3>
                            <small class="text-muted">Total seluruh barang</small>
                        </div>
                        <div class="bg-primary-subtle rounded p-3">
                            <i class="icon">
                                <svg width="26" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.4" d="M3 7.5L12 2.5L21 7.5V16.5L12 21.5L3 16.5V7.5Z"
                                        fill="currentColor"></path>
                                    <path d="M12 12L21 7.5L12 2.5L3 7.5L12 12Z" fill="currentColor"></path>
                                </svg>
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" data-aos="fade-up" data-aos-delay="150">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-secondary">Total Stok</p>
                            <h3 class="mb-0">{{ number_format($totalStock) }}</h3>
                            <small class="text-muted">Total seluruh stock</small>
                        </div>
                        <div class="bg-info-subtle rounded p-3">
                            <i class="icon">
                                <svg width="26" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.4" d="M4 7C4 4.79 5.79 3 8 3H16C18.21 3 20 4.79 20
7V17C20 19.21 18.21 21 16 21H8C5.79 21 4 19.21 4 17V7Z" fill="currentColor"></path>
                                    <path d="M8 8H16M8 12H16M8 16H12" stroke="currentColor" strokewidth="1.5" stroke-linecap="round"></path>
                                </svg>
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-body">
                    <p class="mb-1 text-secondary">Barang Masuk</p>
                    <h3 class="mb-0 text-success">{{ number_format($totalStockIn) }}</h3>
                    <small class="text-muted">Total seluruh transaksi masuk</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" data-aos="fade-up" data-aos-delay="250">
                <div class="card-body">
                    <p class="mb-1 text-secondary">Barang Keluar</p>
                    <h3 class="mb-0 text-danger">{{ number_format($totalStockOut) }}</h3>
                    <small class="text-muted">Total seluruh transaksi keluar</small>
                </div>
            </div>
        </div>
    </div>
    {{-- Chart dan Transaksi Terbaru --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header">
                    <div class="header-title">
                        <h4 class="card-title mb-1">Grafik Transaksi Bulan Ini</h4>
                        <p class="mb-0 text-secondary">
                            Perbandingan barang masuk dan barang keluar berdasarkan tanggal transaksi.
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="stockChart" height="120"></canvas>
                    @if ($chartLabels->count() == 0)
                    <div class="text-center text-muted py-4">
                        Belum ada transaksi pada bulan ini.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" data-aos="fade-up" data-aos-delay="450">
                <div class="card-header">
                    <div class="header-title">
                        <h4 class="card-title mb-1">Transaksi Terbaru</h4>
                        <p class="mb-0 text-secondary">5 transaksi persediaan terakhir.</p>
                    </div>
                </div>
                <div class="card-body">
                    @forelse ($latestTransactions as $transaction)
                    <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-2">
                        <div>
                            <strong>{{ $transaction->product->name ?? '-' }}</strong>
                            <br>
                            <small class="text-muted">
                                {{ $transaction->transaction_date ? $transaction->transaction_date->format('d-m-Y') : '-' }}
                                —
                                {{ $transaction->user->name ?? '-' }}
                            </small>
                        </div>
                        <div class="text-end">
                            @if ($transaction->type === 'masuk')
                            <span class="badge bg-success">Masuk</span>
                            @else
                            <span class="badge bg-danger">Keluar</span>
                            @endif
                            <br>
                            <small>
                                {{ number_format($transaction->quantity) }}
                                {{ $transaction->product->unit ?? '' }}
                            </small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        Belum ada transaksi.
                    </div>
                    @endforelse
                    <a href="{{ route('reports.index') }}" class="btn btn-outline-primary btn-sm w-100 mt2">
                        Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- Stok Terendah dan Tertinggi --}}
    <div class="row" data-aos="fade-up" data-aos-delay="450">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="header-title">
                        <h4 class="card-title mb-1">5 Stok Terendah</h4>
                        <p class="mb-0 text-secondary">
                            Menampilkan barang dengan stok kurang dari 10.
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topMinProducts as $product)
                                @php
                                $statusLabel = $product->stock > 0 ? 'Tersedia' : 'Tidak Tersedia';
                                $statusClass = $product->stock > 0 ? 'bg-success' : 'bg-danger';
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $product->code }}</small>
                                    </td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>
                                        <strong>{{ number_format($product->stock) }}</strong>
                                        <small class="text-muted">{{ $product->unit }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Belum ada data barang.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="header-title">
                        <h4 class="card-title mb-1">5 Stok Tertinggi</h4>
                        <p class="mb-0 text-secondary">Barang dengan jumlah stok paling banyak (>= 10).</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topMaxProducts as $product)
                                @php
                                $statusLabel = $product->stock > 0 ? 'Tersedia' : 'Tidak Tersedia';
                                $statusClass = $product->stock > 0 ? 'bg-success' : 'bg-danger';
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $product->code }}</small>
                                    </td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>
                                        <strong>{{ number_format($product->stock) }}</strong>
                                        <small class="text-muted">{{ $product->unit }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Belum ada data barang.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<!-- Library Grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        const chartLabels = @json($chartLabels);
        const chartIn = @json($chartIn);
        const chartOut = @json($chartOut);
        const chartCanvas = document.getElementById('stockChart');
        if (chartCanvas && chartLabels.length > 0) {
            new Chart(chartCanvas, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                            label: 'Barang Masuk',
                            data: chartIn,
                            borderWidth: 2,
                            tension: 0.4
                        },
                        {
                            label: 'Barang Keluar',
                            data: chartOut,
                            borderWidth: 2,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection