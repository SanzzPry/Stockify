@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#1e1e2f] via-[#2d2d44] to-[#1e1e2f] text-white py-12 px-6">
        <div class="max-w-4xl mx-auto bg-gray-800 border border-gray-700 shadow-lg rounded-2xl p-10">
            <h1 class="text-3xl font-bold text-purple-400 mb-8 flex items-center gap-3">
                <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20 13V5a2 2 0 00-2-2h-3.28a1 1 0 00-.948.684l-.764 2.296a1 1 0 01-.948.684H10a1 1 0 01-.948-.684L8.288 3.684A1 1 0 007.34 3H4a2 2 0 00-2 2v8">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16h18M8 16v5a2 2 0 002 2h4a2 2 0 002-2v-5">
                    </path>
                </svg>
                Form Transaction
            </h1>

            <form action="{{ route('stock.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                <div class="col-span-1 md:col-span-2">
                    <label for="product_id" class="text-xs text-gray-400">Product</label>
                    <select name="product_id" id="product_id" required
                        class="mt-1 w-full bg-gray-700 text-white rounded-lg border border-gray-600 p-3">
                        <option disabled selected>-- Pilih Produk --</option>
                        @foreach ($product as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="type" class="text-xs text-gray-400">Tipe Transaksi</label>
                    <select name="type" id="type" required
                        class="mt-1 w-full bg-gray-700 text-white rounded-lg border border-gray-600 p-3">
                        <option disabled selected>-- Pilih Tipe Transaksi --</option>
                        <option value="Masuk">Masuk</option>
                        <option value="Keluar">Keluar</option>
                    </select>
                </div>
                <input type="text" name="status" value="Pending" hidden>

                <div>
                    <label for="supplier_id" class="text-xs text-gray-400">Tipe Transaksi</label>
                    <select name="supplier_id" id="supplier_id" required
                        class="mt-1 w-full bg-gray-700 text-white rounded-lg border border-gray-600 p-3">
                        <option disabled selected>-- Pilih Supplier --</option>
                        @foreach ($supplier as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="quantity" class="text-xs text-gray-400">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" min="1" required
                        class="mt-1 w-full bg-gray-700 text-white rounded-lg border border-gray-600 p-3" />
                </div>
                <div>
                    <label for="date" class="text-xs text-gray-400">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ now()->toDateString() }}" required
                        class="mt-1 w-full bg-gray-700 text-white rounded-lg border border-gray-600 p-3">
                </div>
                <div class="md:col-span-2">
                    <label for="notes" class="text-xs text-gray-400">Catatan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="mt-1 w-full bg-gray-700 text-white rounded-lg border border-gray-600 p-3"></textarea>
                </div>
                <div class="md:col-span-2 flex justify-end mt-4">
                    <a href="{{ route('stock.manager') }}"
                        class="mr-4 inline-flex items-center gap-2 px-5 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg shadow hover:bg-gray-700 transition">
                        ← Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow hover:bg-purple-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection