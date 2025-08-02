@extends('layouts.dashboard')
@section('content')



    <div class="px-4 pt-6 pb-40 mb-40">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <!-- Card: Barang Masuk -->
            <div
                class="flex items-center p-6 bg-blue-50 border border-blue-200 rounded-lg shadow-sm dark:bg-blue-900 dark:border-blue-700">
                <div class="p-3 mr-4 text-blue-700 bg-blue-100 rounded-full dark:bg-blue-800 dark:text-blue-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a2 2 0 002 2h4m4-3v3a2 2 0 002 2h2a2 2 0 002-2v-3M4 12V8a2 2 0 012-2h4m4 4V4a2 2 0 012-2h2a2 2 0 012 2v4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-blue-600 dark:text-blue-300">Total Barang Masuk</h3>
                    <p class="text-3xl font-bold text-blue-900 dark:text-white">{{ $incomingStock }}</p>
                    <p class="text-sm text-blue-500 dark:text-blue-400">Hari ini</p>
                </div>
            </div>

            <!-- Card: Barang Keluar -->
            <div
                class="flex items-center p-6 bg-yellow-50 border border-yellow-200 rounded-lg shadow-sm dark:bg-yellow-900 dark:border-yellow-700">
                <div class="p-3 mr-4 text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-800 dark:text-yellow-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17v-6h13m0 0l-4-4m4 4l-4 4M4 4h6v16H4z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-yellow-600 dark:text-yellow-300">Total Barang Keluar</h3>
                    <p class="text-3xl font-bold text-yellow-900 dark:text-white">{{ $outgoingStock }}</p>
                    <p class="text-sm text-yellow-500 dark:text-yellow-400">Hari ini</p>
                </div>
            </div>

            <!-- Card: Stok Menipis -->
            <div
                class="flex items-center p-6 bg-red-50 border border-red-200 rounded-lg shadow-sm dark:bg-red-900 dark:border-red-700">
                <div class="p-3 mr-4 text-red-700 bg-red-100 rounded-full dark:bg-red-800 dark:text-red-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 9v2m0 4v.01M21 12A9 9 0 113 12a9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-red-600 dark:text-red-300">Stok</h3>
                    <p class="text-3xl font-bold text-red-900 dark:text-white">{{ $lowStock }}</p>
                    <p class="text-sm text-red-500 dark:text-red-400">Produk Menipis. Perlu Segera Diisi</p>
                </div>
            </div>
        </div>
    </div>


@endsection