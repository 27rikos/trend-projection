@extends('partials.main')
@section('title', 'Dashboard')
@push('chart')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush
@section('main')
    <div class="pc-content">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-primary order-card">
                    <div class="card-body">
                        <h6 class="text-white">Jumlah Obat</h6>
                        <h2 class="text-end text-white"><i
                                class="fa-solid fa-pills float-start"></i><span>{{ $obat }}</span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-success order-card">
                    <div class="card-body">
                        <h6 class="text-white">Total Penjualan</h6>
                        <h2 class="text-end text-white"><i
                                class="fa-solid fa-cart-shopping float-start"></i><span>{{ $sale }}</span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-grd-warning order-card">
                    <div class="card-body">
                        <h6 class="text-white">Jenis Obat</h6>
                        <h2 class="text-end text-white"><i
                                class="fa-solid fa-list float-start"></i><span>{{ $type }}</span>
                        </h2>
                    </div>
                </div>
            </div>
            <!-- Recent Orders end -->
            <div id="chart" class="my-5"></div>

            <script>
                // Data dari controller, diambil langsung dalam bentuk PHP array dan disiapkan untuk JavaScript
                var jenisObat = @json($obats->pluck('jenis'));
                var totalJumlah = @json($obats->pluck('total_jumlah'));

                // Menampilkan data dengan ApexCharts
                var options = {
                    chart: {
                        type: 'bar'
                    },
                    series: [{
                        name: 'Jumlah Obat',
                        data: totalJumlah
                    }],
                    xaxis: {
                        categories: jenisObat,
                        title: {
                            text: 'Jenis Obat'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Total Jumlah'
                        }
                    },
                    title: {
                        text: 'Jumlah Obat per Jenis Obat',
                        align: 'center'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            </script>
            <div id="spline"></div>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Penjualan Obat per Bulan</title>
                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            </head>

            <body>

                <div id="chart"></div>

                <<script>
                    // Data dummy untuk bulan
                    var bulanPenjualan = [
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ];

                    // Data penjualan dummy yang menunjukkan fluktuasi (naik dan turun)
                    var totalPenjualan2020 = [50, 70, 60, 80, 90, 100, 110, 95, 130, 120, 140, 130];
                    var totalPenjualan2021 = [60, 80, 75, 90, 85, 110, 120, 115, 140, 160, 150, 170];
                    var totalPenjualan2022 = [70, 90, 80, 110, 120, 105, 130, 140, 160, 155, 180, 175];
                    var totalPenjualan2023 = [80, 110, 90, 130, 125, 140, 150, 160, 165, 190, 185, 200];

                    // Menampilkan data dengan ApexCharts
                    var options = {
                        chart: {
                            type: 'area', // Spline area chart
                            zoom: {
                                enabled: false
                            }
                        },
                        series: [{
                                name: '2020',
                                data: totalPenjualan2020
                            },
                            {
                                name: '2021',
                                data: totalPenjualan2021
                            },
                            {
                                name: '2022',
                                data: totalPenjualan2022
                            },
                            {
                                name: '2023',
                                data: totalPenjualan2023
                            }
                        ],
                        xaxis: {
                            categories: bulanPenjualan,
                            title: {
                                text: 'Bulan'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Jumlah Penjualan'
                            }
                        },
                        title: {
                            text: 'Penjualan Obat per Bulan (2020-2023)',
                            align: 'center'
                        },
                        fill: {
                            opacity: 0.5 // Opacity untuk area chart
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#spline"), options);
                    chart.render();
                </script>

            </body>

            </html>

        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
