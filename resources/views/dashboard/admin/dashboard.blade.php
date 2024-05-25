@extends('dashboard.admin.template.main')

@push('styles')
    <style>
        .container {
            padding-left: 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .col-md-6 {
            width: 40%;
            margin-right: 10px;
        }

        .card {
            max-width: 1400px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .chart-container {
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 me-2">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-bold m-2">Total Pengajuan Foto</h2>
                    </div>
                    <div class="card-body chart-container">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-bold m-2">Proses Pengajuan Foto</h2>
                    </div>
                    <div class="card-body chart-container">
                        <div id="Proseschart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
            chart: {
                type: 'bar',
                foreColor: '#333',
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 3,
                    blur: 4,
                    opacity: 0.2
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 3,
                    columnWidth: '10%',
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            series: [{
                name: 'Photo Status',
                data: [{{ $statusId1 }}, {{ $statusId2 }}, {{ $statusId3 }}, {{ $statusId4 }},
                    {{ $total }}
                ]
            }],
            xaxis: {
                categories: ['Sedang Diajukan', 'Ajuan Sedang ditinjau', 'Ajuan Diterima', 'Ajuan Ditolak', 'Total']
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        var Prosesoptions = {
            chart: {
                type: 'bar',
                foreColor: '#333',
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 3,
                    blur: 4,
                    opacity: 0.2
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 30,
                    columnWidth: '10%',
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            series: [{
                name: 'Proses Photo Status',
                data: [{{ $prosesStatus }}]
            }],
            xaxis: {
                categories: ['Ajuan Sedang ditinjau']
            }
        };

        var Proseschart = new ApexCharts(document.querySelector("#Proseschart"), Prosesoptions);
        Proseschart.render();
    </script>
@endpush
