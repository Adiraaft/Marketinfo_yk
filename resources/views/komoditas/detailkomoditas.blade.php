@extends('layouts.home')

@section('title', 'Detail Pasar')

@section('navbar')
    <x-navbar-color />

@endsection

@section('content')
    <div class="mx-4 lg:mx-10 mt-5 mb-20">
        <a href="{{ url()->previous() }}#commodity-section"
            class="text-blue-500 hover:underline mt-3 text-sm lg:text-base inline-block">
            ← Kembali
        </a>
        <h2 class="text-xl lg:text-2xl font-bold mt-4 text-center">Grafik Harga {{ $commodity->name_commodity }} </h2>
        <h2 class="text-xl lg:text-2xl font-bold mt-2 lg:mt-4 text-center">{{ $marketName }}</h2>
        <div class="grid grid-cols-12 mt-6 lg:mt-10 gap-8">
            <div class="col-span-12 md:col-span-4 space-y-5">
                <img src="{{ $commodity->image ? asset('storage/commodity_images/' . $commodity->image) : asset('images/no-image.png') }}"
                    class="w-full h-60 lg:h-100 object-cover rounded-lg" alt="{{ $commodity->name_commodity }}">
            </div>
            <div class="col-span-12 md:col-span-8 space-y-4">
                <h2 class="lg:text-xl font-bold">Harga {{ $commodity->name_commodity }}
                    ({{ $priceToday ? \Carbon\Carbon::parse($priceToday->date)->translatedFormat('d F Y') : '-' }})
                </h2>
                <div class="bg-white rounded-2xl shadow-md p-6 max-w-2xl border border-gray-200">
                    {{-- Header --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="lg:text-lg font-semibold tracking-wide">
                                {{ $commodity->name_commodity }}
                            </h3>
                            <p class="text-xs lg:text-sm text-gray-500">
                                {{ $marketName }}
                            </p>
                        </div>

                        <span class="text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-600 font-medium">
                            Harga Hari Ini
                        </span>
                    </div>

                    {{-- Harga Utama --}}
                    <div class="mt-6 flex items-end gap-3">
                        <p class="text-2xl lg:text-4xl font-bold text-secondary leading-none">
                            Rp {{ number_format($priceToday->price ?? 0, 0, ',', '.') }}
                        </p>
                        <span class="text-xs lg:text-sm text-gray-500 mb-1">
                            /{{ $commodity->unit->name_unit }}
                        </span>
                    </div>

                    {{-- Trend --}}
                    @if (!is_null($trend))
                        <div
                            class="mt-3 flex items-center gap-2 text-xs lg:text-sm
                            {{ $trend === 'up' ? 'text-red-500' : 'text-green-600' }}">
                            <i data-lucide="{{ $trend === 'up' ? 'trending-up' : 'trending-down' }}" class="w-4 h-4"></i>

                            <span>
                                {{ $percent }}%
                                (Rp {{ number_format($diff, 0, ',', '.') }})
                            </span>
                            <span class="text-gray-400 text-sm lg:text-base">dibanding kemarin</span>
                        </div>
                    @endif

                    {{-- Meta --}}
                    <div class="mt-6 flex justify-between text-xs text-gray-400 border-t pt-4">
                        <span>
                            Terakhir Update:
                            {{ \Carbon\Carbon::parse($priceToday->date ?? now())->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex flex-col sm:flex-row sm:justify-between gap-4 mt-8 w-full">

            <!-- FILTER OPTIONS -->
            <div class="flex flex-col sm:flex-row flex-wrap gap-4 w-full sm:w-auto">
                <div class="text-sm flex flex-col">
                    <label for="filter_time" class="block mb-1 text-gray-700">Pilih Tanggal</label>
                    <select id="filter_time" name="filter_time"
                        class="border border-gray-300 rounded-md p-1 w-full sm:w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                        <option value="7">7 Hari Terakhir</option>
                        <option value="30">30 Hari Terakhir</option>
                        <option value="365">1 Tahun Terakhir</option>
                    </select>
                </div>

                <div class="text-sm flex flex-col">
                    <label for="filter_market" class="block mb-1 text-gray-700">Pilih Pasar</label>
                    <select id="filter_market" name="filter_market"
                        class="border border-gray-300 rounded-md p-1 w-full sm:w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                        <option value="all">Semua Pasar</option>
                        @foreach ($markets as $m)
                            <option value="{{ $m->id_market }}">{{ $m->name_market }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button id="btn_filter_chart"
                        class="py-1.5 px-3 rounded-md bg-secondary cursor-pointer w-full sm:w-auto">
                        <p class="text-white text-xs font-medium">Tampilkan</p>
                    </button>
                </div>
            </div>

            <!-- EXPORT BUTTONS -->
            <div class="flex flex-wrap gap-2 items-end justify-start sm:justify-end w-full sm:w-auto">
                <button class="py-1.5 px-3 rounded-md bg-green-500 cursor-pointer w-full sm:w-auto">
                    <p class="text-white text-xs font-medium">Export Excel</p>
                </button>
                <button class="py-1.5 px-3 rounded-md bg-red-500 cursor-pointer w-full sm:w-auto">
                    <p class="text-white text-xs font-medium">Export PDF</p>
                </button>
            </div>

        </div>

        <!-- CHART -->
        <div class="bg-white w-full p-4 sm:p-6 rounded-lg shadow-md mt-6 mx-auto">
            <div id="commodityChart" class="w-full h-64 sm:h-80"></div>
        </div>
    </div>

    <script>
        let chartInstance;

        function renderChart(labels, data) {
            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: true
                    }
                },
                series: [{
                    name: 'Harga (Rp)',
                    data: data
                }],
                xaxis: {
                    categories: labels,
                    labels: {
                        rotate: -45
                    }
                },
                yaxis: {
                    title: {
                        text: 'Harga (Rp)'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "Rp " + val.toLocaleString();
                        }
                    }
                }
            };

            if (chartInstance) {
                chartInstance.updateOptions({
                    series: [{
                        data: data
                    }],
                    xaxis: {
                        categories: labels
                    }
                });
            } else {
                chartInstance = new ApexCharts(document.querySelector("#commodityChart"), options);
                chartInstance.render();
            }
        }

        // AJAX fetch chart data
        document.getElementById('btn_filter_chart').addEventListener('click', function() {
            const days = document.getElementById('filter_time').value;
            const market = document.getElementById('filter_market').value;

            fetch(`{{ url('komoditas/' . $commodity->id_commodity . '/chart') }}?days=${days}&market=${market}`)
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        const labels = res.data.map(d => d.date);
                        const data = res.data.map(d => parseFloat(d.price));
                        renderChart(labels, data);
                    }
                });
        });

        // render awal
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('btn_filter_chart').click();
        });
    </script>
@endsection
