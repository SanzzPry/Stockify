@extends('layouts.dashboard')
@section('content')

    <div class="px-4 pt-6">

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <!-- Card: Total Produk -->
            <div
                class="p-5 bg-indigo-100 dark:bg-indigo-900 border border-indigo-300 dark:border-indigo-700 rounded-2xl shadow hover:shadow-lg transition duration-300 ease-in-out">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-indigo-700 dark:text-indigo-300">
                    <x-heroicon-o-cube class="w-5 h-5" /> Total Produk
                </h3>
                <span class="text-3xl font-bold text-gray-900 dark:text-white mt-2 block">{{ $totalProduct }}</span>

            </div>

            <!-- Card: Total Supplier -->
            <div
                class="p-5 bg-pink-100 dark:bg-pink-900 border border-pink-300 dark:border-pink-700 rounded-2xl shadow hover:shadow-lg transition duration-300 ease-in-out">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-pink-700 dark:text-pink-300">
                    <x-heroicon-o-truck class="w-5 h-5" /> Total Supplier
                </h3>
                <span class="text-3xl font-bold text-gray-900 dark:text-white mt-2 block">{{ $totalSupplier }}</span>

            </div>

            <!-- Card: Transaksi Masuk -->
            <div
                class="p-5 bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 rounded-2xl shadow hover:shadow-lg transition duration-300 ease-in-out">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-green-700 dark:text-green-300">
                    <x-heroicon-o-arrow-down-tray class="w-5 h-5" /> Transaksi Masuk
                </h3>
                <span class="text-3xl font-bold text-gray-900 dark:text-white mt-2 block">{{ $incomingTransaction }}</span>

            </div>

            <!-- Card: Transaksi Keluar -->
            <div
                class="p-5 bg-yellow-100 dark:bg-yellow-900 border border-yellow-300 dark:border-yellow-700 rounded-2xl shadow hover:shadow-lg transition duration-300 ease-in-out">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-yellow-700 dark:text-yellow-300">
                    <x-heroicon-o-arrow-up-tray class="w-5 h-5" /> Transaksi Keluar
                </h3>
                <span class="text-3xl font-bold text-gray-900 dark:text-white mt-2 block">{{ $outgoingTransaction }}</span>

            </div>
        </div>

        <div class="grid grid-cols-1 my-4 xl:grid-cols-2 xl:gap-4">

            <!-- Right Content -->

        </div>
        <!-- Main widget -->
        <div
            class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-shrink-0">
                    <h3 class="text-base font-light text-gray-500 dark:text-gray-400">Grafik Stock Barang</h3>
                </div>
            </div>
            <canvas id="stockChart" class="m-auto w-full"></canvas>
        </div>
        <!-- 2 columns -->
        <div class="grid grid-cols-1 my-4 xl:grid-cols-2 xl:gap-4">


        </div>

        <div class="xl:gap-4">
            <!-- Activity Card -->
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 xl:mb-0">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Latest Activity</h3>
                    <a href="{{ route('activity.download') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <x-heroicon-o-arrow-down-tray class="w-4 h-4 mr-2" />
                        Generate report
                    </a>
                </div>
                <ol class="relative border-l border-gray-200 dark:border-gray-700">
                    @forelse($activity as $history)
                        <li class="mb-10 ml-4">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-800 dark:bg-gray-700">
                            </div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                                {{ \Carbon\Carbon::parse($history['timestamp'])->translatedFormat('d F Y, H:i') }}
                            </time>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $history['activity'] }}
                            </h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                                Oleh <span class="font-medium text-gray-800 dark:text-gray-300">{{ $history['user'] }}</span>
                                ({{ $history['role'] }})
                            </p>
                        </li>
                    @empty
                        <li class="ml-4 text-gray-500 dark:text-gray-400">Belum ada aktivitas</li>
                    @endforelse
                </ol>

            </div>
            <!--Carousel widget -->

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module">
        import { initStockChart } from '/assets/js/charts.js';
        initStockChart(@json($transactionData));
    </script>




@endsection