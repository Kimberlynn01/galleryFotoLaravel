@extends('dashboard.admin.template.main')


@push('scripts')
    <style>
        .container {
            max-width: 1200px;
            padding-left: 15px;

        }

        .row {
            display: flex;
            flex-wrap: wrap;

        }

        .col-md-6 {
            width: 50%;
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
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="font-bold m-2">Total Pengajuan Foto</h2>
                    </div>
                    <div class="card-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
            chart: {
                type: 'bar'
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
    </script>
@endpush
