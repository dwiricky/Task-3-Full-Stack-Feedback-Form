@extends('admin.layouts.master')

@section('body')
<main class="main-content border-radius-lg ">
    <!-- Navbar -->
    @include('admin.components.navbar')
    <div class="p-4 mx-4" style="min-height: 80vh">
        <p>Hai, CAPSTONE#1_FS2 / Dashboard</p>
        {{-- Start Here --}}
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="text-center">
                    Chart Data Barang
                </div>
                <div class="card mb-3">
                    <div class="card-body p-3">
                      <div class="chart">
                        <canvas id="data_jumlah" class="chart-canvas" height="300px"></canvas>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="text-center">
                    Chart Data Transaksi dalam Setahun
                </div>
                <div class="card mb-3">
                    <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="data_transaksi" class="chart-canvas" height="300px"></canvas>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div>
                    <div class="text-center">
                        <h3>Pendapatan Hari Ini</h3>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body text-center p-3">
                            <?php
                                $harga = (string) $today;
                                $harga = strrev($harga);
                                $arr = str_split($harga, '3');
                                        
                                $ganti_format_harga = implode('.', $arr);
                                $harga = strrev($ganti_format_harga);    
                            ?>
                            <h4>Rp. {{$harga}}</h4>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-center">
                        <h3>Pendapatan Bulan Ini</h3>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body text-center p-3">
                            <?php
                                $harga = (string) $this_month;
                                $harga = strrev($harga);
                                $arr = str_split($harga, '3');
                                        
                                $ganti_format_harga = implode('.', $arr);
                                $harga = strrev($ganti_format_harga);    
                            ?>
                            <h4>Rp. {{$harga}}</h4>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-center">
                        <h3>Pendapatan Tahun Ini</h3>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body text-center p-3">
                            <?php
                                $harga = (string) $this_year;
                                $harga = strrev($harga);
                                $arr = str_split($harga, '3');
                                        
                                $ganti_format_harga = implode('.', $arr);
                                $harga = strrev($ganti_format_harga);    
                            ?>
                            <h4>Rp. {{$harga}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.components.footer')
</main>
@endsection
@section('add-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('data_jumlah');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
        labels: <?php echo json_encode($kategori);?>,
        datasets: [{
            label: '# Jumlah',
            data: <?php echo json_encode(array_values($j_barang));?>,
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });

    const ctx2 = document.getElementById('data_transaksi');

    new Chart(ctx2, {
        type: 'line',
        data: {
            
            datasets: [{
                label: '# Pendapatan',
                data: <?php echo json_encode($pendapatan_per_bulan);?>,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection