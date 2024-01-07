@extends('layouts.admin')

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('breadcrumb')
    {{-- <li class="breadcrumb-item">{{ __('Home') }}</li> --}}
@endsection
{{-- @section('action-button')
        @if(\Auth::user()->parent == 0)
            <a href="#" class="btn btn-sm btn-primary btn-icon cp_link" data-link="" data-toggle="tooltip" data-original-title="{{__('Click to copy invoice link')}}" title="{{__('Click To Copy Support Ticket Url')}}" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="ti ti-copy"></i>
            </a>
    @endif
@endsection --}}
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-7">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body dash_card_height">
                                    <div class="theme-avtar bg-primary">
                                        <i class="fas fa-list-alt"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                                    <h6 class="mb-3">{{ __('Categories') }}</h6>
                                    <h3 class="mb-0">{{ $categories }}</h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body dash_card_height">
                                    <div class="theme-avtar bg-info">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Open') }}</p>
                                    <h6 class="mb-3">{{ __('Tickets') }}</h6>
                                    <h3 class="mb-0">{{ $open_ticket }} </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body dash_card_height">
                                    <div class="theme-avtar bg-warning">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Closed') }}</p>
                                    <h6 class="mb-3">{{ __('Tickets') }}</h6>
                                    <h3 class="mb-0">{{ $close_ticket }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body dash_card_height">
                                    <div class="theme-avtar bg-danger">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2">{{ __('Total') }}</p>
                                    <h6 class="mb-3">{{ __('Agents') }}</h6>
                                    <h3 class="mb-0">{{ $agents }}</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Tickets by Category') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <div id="categoryPie"></div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('This Year Tickets') }}</h5>
                        </div>
                        <div class="card-body">
                                        <form id="chartFilterForm" action="dashboard">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="filterProvince" class="form-label">{{ __('Select Province') }}:</label>
                                                    <select id="filterProvince" class="form-select" name="filterProvince">
                                                        <option value="" selected>{{ __('All Provinces') }}</option>
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->id }}" {{ $province->id == $request->input('filterProvince') ? 'selected' : '' }}>
                                                                {{ $province->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filterCity" class="form-label">{{ __('Select City') }}:</label>
                                                    <select id="filterCity" class="form-select" name="filterCity">
                                                        <option value="" selected>{{ __('All Cities') }}</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}" {{ $city->id == $request->input('filterCity') ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Sisanya tetap seperti sebelumnya -->
                                                <div class="col-md-3">
                                                    <label for="filterMonth" class="form-label">{{ __('Select Month') }}:</label>
                                                    @php
                                                        $selectedMonth = isset($request) ? $request->input('filterMonth') : date('n');
                                                    @endphp
                                                    <select id="filterMonth" class="form-select" name="filterMonth">
                                                        <!-- Daftar opsi bulan (1-12) -->
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}" {{ $i == (int)$selectedMonth ? 'selected' : '' }}>
                                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filterYear" class="form-label">{{ __('Select Year') }}:</label>
                                                    <select id="filterYear" class="form-select" name="filterYear">
                                                        <!-- Daftar opsi tahun (dari tahun sekarang hingga 5 tahun ke belakang) -->
                                                        @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                                            <option value="{{ $i }}" {{ $i == date('Y') || $i == $request->input('filterYear') ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Apply</button>
                                                </div>
                                            </div>

                                            {{-- <label for="filterMonth" class="form-label">{{ __('Select Month') }}:</label>
                                            @php
                                                $selectedMonth = isset($request) ? $request->input('filterMonth') : date('n');
                                            @endphp

                                            <select id="filterMonth" class="form-select" name="filterMonth">
                                                <!-- Daftar opsi bulan (1-12) -->
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ $i == (int)$selectedMonth ? 'selected' : '' }}>
                                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                    </option>
                                                @endfor
                                            </select>

                                            <label for="filterYear" class="form-label">{{ __('Select Year') }}:</label>
                                            <select id="filterYear" class="form-select" name="filterYear">
                                                <!-- Daftar opsi tahun (dari tahun sekarang hingga 5 tahun ke belakang) -->
                                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                                    <option value="{{ $i }}" {{ $i == date('Y') || $i == $request->input('filterYear') ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>

                                            <button type="submit" class="btn btn-primary">Apply</button> --}}
                                        </form>
                            <div id="chartBar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('List Province Ticket') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($tickets->isEmpty())
                                <p>No tickets found for the selected provinces.</p>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Province</th>
                                            <th>Count</th>
                                            <!-- Tambahkan kolom lain sesuai kebutuhan -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets as $ticket)
                                            <tr>
                                                <td>{{ $ticket->id }}</td>
                                                <td>{{ $ticket->province_name }}</td>
                                                <td>{{ $ticket->ticket_count }}</td>

                                                <!-- Tambahkan kolom lain sesuai kebutuhan -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Category Ticket List') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('On Hold') }}</th>
                                        <th>{{ __('In Progress') }}</th>
                                        <th>{{ __('Closed') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoriesChartTable as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->on_hold_count }}</td>
                                            <td>{{ $category->in_progress_count }}</td>
                                            <td>{{ $category->closed_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Response Times -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Response Time by Agents') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Agent') }}</th>
                                        <th>{{ __('Response Time') }}</th>
                                        <th>{{ __('Ticket Count') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agentData as $agent)
                                        <tr>
                                            <td>{{ $agent->agent_name }}</td>
                                            <td>{{ $agent->total_response_time }} hours</td>
                                            <td>{{ $agent->ticket_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@push('scripts')

        <script>
            $(document).ready(function () {
                // Saat province berubah, ambil id province dan perbarui dropdown city
                $('#filterProvince').change(function () {
                    var selectedProvinceId = $(this).val();
                    updateCityDropdown(selectedProvinceId);
                });

                // Fungsi untuk memperbarui dropdown city
                function updateCityDropdown(selectedProvinceId) {
                    // Kirim AJAX request ke server untuk mendapatkan cities berdasarkan selectedProvinceId
                    $.ajax({
                        url: '{{ route("admin.get.cities.by.province") }}', // Gantilah dengan URL yang sesuai
                        method: 'GET',
                        data: { province_id: selectedProvinceId },
                        success: function (data) {
                            // Perbarui dropdown city dengan data baru
                            $('#filterCity').html('<option value="" selected>{{ __("All Cities") }}</option>');
                            $.each(data, function (key, value) {
                                $('#filterCity').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        },
                        error: function (error) {
                            console.error('Error:', error);
                        }
                    });
                }

                // Inisialisasi dropdown city saat halaman dimuat
                var selectedProvinceId = $('#filterProvince').val();
                updateCityDropdown(selectedProvinceId);
            });
        </script>

    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script>
        var arChart;  // Declare arChart as a global variable

        (function() {
            var chartBarOptions = {
                series: [{
                    name: '{{ __("Tickets") }}',
                    data: {!! json_encode(array_values($monthData)) !!}
                }],

                chart: {
                    height: 150,
                    type: 'area',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: {!! json_encode(array_keys($monthData)) !!},
                    title: {
                        text: '{{ __('Months') }}'
                    }
                },
                colors: ['#ffa21d', '#FF3A6E'],
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                markers: {
                    size: 4,
                    colors: ['#ffa21d', '#FF3A6E'],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('Tickets') }}'
                    },
                    tickAmount: 3,
                    min: 10,
                    max: 70,
                }
            };
            arChart = new ApexCharts(document.querySelector("#chartBar"), chartBarOptions);
            arChart.render();
        })();
        (function() {
            var categoryPieOptions = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: {!! json_encode($chartData['value']) !!},
                colors: {!! json_encode($chartData['color']) !!},
                labels: {!! json_encode($chartData['name']) !!},
                legend: {
                    show: true
                }
            };
            var categoryPieChart = new ApexCharts(document.querySelector("#categoryPie"), categoryPieOptions);
            categoryPieChart.render();
        })();


    </script>
@endpush

{{--
     function applyChartFilter() {
            var form = document.getElementById('chartFilterForm');
            var selectedMonth = form.elements['filterMonth'].value;
            var selectedYear = form.elements['filterYear'].value;

            // Kirim permintaan AJAX ke server dengan parameter bulan dan tahun yang dipilih
            $.ajax({
                url: '{{ route("admin.dashboard") }}',
                method: 'GET',
                data: {
                    month: selectedMonth,
                    year: selectedYear
                },
                success: function (data) {
                    // Update chart dengan data baru
                    var newChartOptions = {
                        series: [{
                            name: '{{ __("Tickets") }}',
                            data: data.monthData
                        }],
                        xaxis: {
                            categories: data.monthLabels
                        }
                    };

                    arChart.updateOptions(newChartOptions);
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        }
@push('scripts')
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>

    <script>
        (function() {
            var chartBarOptions = {
                series: [{
                    name: '{{ __("Tickets") }}',
                    // data: [40, 20, 60, 15, 50, 65, 20, 40, 20, 60, 15, 50]
                    data: {!! json_encode(array_values($monthData)) !!}
                }, ],

                chart: {
                    height: 150,
                    type: 'area',
                    // type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                // xaxis: {
                //     categories: {!! json_encode(array_keys($monthData)) !!},
                //     title: {
                //         text: '{{ __('Months') }}'
                //     }
                // },
                // colors: ['#ffa21d', '#FF3A6E'],
                xaxis: {
                categories: {!! json_encode(array_keys($monthData)) !!},
                title: {
                    text: '{{ __('Months') }}'
                }
                },
                colors: ['#ffa21d', '#FF3A6E'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                markers: {
                    size: 4,
                    colors: ['#ffa21d', '#FF3A6E'],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('Tickets') }}'
                    },
                    tickAmount: 3,
                    min: 10,
                    max: 70,
                }
            };
            var arChart = new ApexCharts(document.querySelector("#chartBar"), chartBarOptions);
            arChart.render();
        })();
        (function() {
            var categoryPieOptions = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: {!! json_encode($chartData['value']) !!},
                colors: {!! json_encode($chartData['color']) !!},
                labels: {!! json_encode($chartData['name']) !!},
                legend: {
                    show: true
                }
            };
            var categoryPieChart = new ApexCharts(document.querySelector("#categoryPie"), categoryPieOptions);
            categoryPieChart.render();
        })();

     function applyChartFilter() {
        var form = document.getElementById('chartFilterForm');
        var selectedMonth = form.elements['filterMonth'].value;
        var selectedYear = form.elements['filterYear'].value;

        // Kirim permintaan AJAX ke server dengan parameter bulan dan tahun yang dipilih
        $.ajax({
            url: '{{ route("admin.dashboard") }}',
            method: 'GET',
            data: {
                month: selectedMonth,
                year: selectedYear
            },
            success: function (data) {
                // Update chart dengan data baru
                var newChartOptions = {
                    series: [{
                        name: '{{ __("Tickets") }}',
                        data: data.monthData
                    }],
                    xaxis: {
                        categories: data.monthLabels
                    }
                };

                arChart.updateOptions(newChartOptions);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });

        var arChart = new ApexCharts(document.querySelector("#chartBar"), chartBarOptions);
            arChart.render();
    }
</script>

@endpush --}}
