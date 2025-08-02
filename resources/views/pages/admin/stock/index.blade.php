@extends('layouts.dashboard')

@section('content')
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="#"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                    aria-current="page">Transaction</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All Transaction</h1>
            </div>
        </div>
    </div>

    <div class="flex flex-col mt-5">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">

                    <div class="flex flex-col mt-5 space-y-6">

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded shadow">
                            <form method="GET" action="{{ route('stock.index') }}"
                                class="flex flex-col md:flex-row md:items-end gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter
                                        Berdasarkan
                                        Tipe</label>
                                    <select name="type"
                                        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white dark:border-gray-600">
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="Masuk" {{ request('type') == 'Masuk' ? 'selected' : '' }}>Masuk
                                        </option>
                                        <option value="Keluar" {{ request('type') == 'Keluar' ? 'selected' : '' }}>Keluar
                                        </option>
                                    </select>
                                </div>

                                <div class="flex gap-2">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Tampilkan</button>
                                    @if(request('type'))
                                        <a href="{{ route('stock.exportByType', ['type' => request('type')]) }}"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Export PDF</a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded shadow">
                            <form method="GET" action="{{ route('stock.index') }}"
                                class="flex flex-col md:flex-row md:items-end gap-4 flex-wrap">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                                    <select name="category_id"
                                        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white dark:border-gray-600">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($category as $cat)
                                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari
                                        Tanggal</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white dark:border-gray-600">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai
                                        Tanggal</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white dark:border-gray-600">
                                </div>

                                <div class="flex gap-2">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Tampilkan</button>
                                    @if(request('category_id') || (request('start_date') && request('end_date')))
                                        <a href="{{ route('stock.exportByFilter', request()->only('category_id', 'start_date', 'end_date')) }}"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Export PDF</a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        @if (request('type'))
                            <section class="mb-8">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                                    Hasil Filter Berdasarkan Tipe
                                </h2>
                                <div
                                    class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                                    <table class="min-w-full text-sm text-left">
                                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                                            <tr>
                                                <th class="p-3 border dark:border-gray-600">No</th>
                                                <th class="p-3 border dark:border-gray-600">Tanggal</th>
                                                <th class="p-3 border dark:border-gray-600">Produk</th>
                                                <th class="p-3 border dark:border-gray-600">Tipe</th>
                                                <th class="p-3 border dark:border-gray-600">Jumlah</th>
                                                <th class="p-3 border dark:border-gray-600">Catatan</th>
                                                <th class="p-3 border dark:border-gray-600">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100">
                                            @forelse ($transactionsByType as $i => $item)
                                                <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="p-3 border">{{ $i + 1 }}</td>
                                                    <td class="p-3 border">{{ $item->date }}</td>
                                                    <td class="p-3 border">{{ $item->products->name ?? '-' }}</td>
                                                    <td class="p-3 border">{{ $item->type }}</td>
                                                    <td class="p-3 border">{{ $item->quantity }}</td>
                                                    <td class="p-3 border">{{ $item->notes }}</td>
                                                    <td class="p-3 border">{{ $item->status }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center p-4 text-gray-500 dark:text-gray-300">
                                                        Data tidak ditemukan
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        @endif

                        @if(request('category_id') || (request('start_date') && request('end_date')))
                            <section>
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                                    Hasil Filter Berdasarkan Kategori & Periode
                                </h2>
                                <div
                                    class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                                    <table class="min-w-full text-sm text-left">
                                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                                            <tr>
                                                <th class="p-3 border dark:border-gray-600">No</th>
                                                <th class="p-3 border dark:border-gray-600">Tanggal</th>
                                                <th class="p-3 border dark:border-gray-600">Produk</th>
                                                <th class="p-3 border dark:border-gray-600">Kategori</th>
                                                <th class="p-3 border dark:border-gray-600">Jumlah</th>
                                                <th class="p-3 border dark:border-gray-600">Catatan</th>
                                                <th class="p-3 border dark:border-gray-600">Supplier</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100">
                                            @forelse ($transactionsByFilter as $i => $item)
                                                <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="p-3 border">{{ $i + 1 }}</td>
                                                    <td class="p-3 border">{{ $item->date }}</td>
                                                    <td class="p-3 border">{{ $item->products->name ?? '-' }}</td>
                                                    <td class="p-3 border">{{ $item->products->categories->name ?? '-' }}</td>
                                                    <td class="p-3 border">{{ $item->quantity }}</td>
                                                    <td class="p-3 border">{{ $item->notes }}</td>
                                                    <td class="p-3 border">{{ $item->products->suppliers->name ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center p-4 text-gray-500 dark:text-gray-300">
                                                        Data tidak ditemukan
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection