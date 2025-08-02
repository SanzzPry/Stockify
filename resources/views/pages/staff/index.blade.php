@extends('layouts.dashboard')

@section('content')
    <div class="px-6 py-8 min-h-[calc(100vh-4rem)] bg-[#0f172a] text-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Barang Masuk -->
            <div
                class="bg-gradient-to-tr from-blue-700 to-blue-500 rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-blue-200">Barang Masuk</h4>
                        <p class="text-4xl font-bold text-white mt-1">{{ $incomingItem }}</p>
                        <p class="text-sm text-blue-100 mt-2">Perlu Diperiksa</p>
                    </div>
                    <div class="text-blue-100 bg-blue-800 rounded-full p-3">
                        <!-- Heroicon: Arrow Down Tray -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Barang Keluar -->
            <div
                class="bg-gradient-to-tr from-indigo-700 to-indigo-500 rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-indigo-200">Barang Keluar</h4>
                        <p class="text-4xl font-bold text-white mt-1">{{ $outgoingItem }}</p>
                        <p class="text-sm text-indigo-100 mt-2">Perlu Disiapkan</p>
                    </div>
                    <div class="text-indigo-100 bg-indigo-800 rounded-full p-3">
                        <!-- Heroicon: Arrow Up Tray -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v2a2 2 0 002 2h12a2 2 0 002-2V4M7 14l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection