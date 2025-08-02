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
                    Detail Product
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ([
        ['label' => 'Name Product', 'value' => $product->name],
        ['label' => 'SKU', 'value' => $product->sku],
        ['label' => 'Purchase Price', 'value' => 'Rp ' . number_format($product->purchase_price, 0, ',', '.')],
        ['label' => 'Selling Price', 'value' => 'Rp ' . number_format($product->selling_price, 0, ',', '.')],
        ['label' => 'Category', 'value' => $product->categories->name ?? '-'],
        ['label' => 'Supplier', 'value' => $product->suppliers->name ?? '-'],
    ] as $item)
                        <div class="bg-gray-700 rounded-xl p-4 border border-gray-600">
                            <p class="text-xs text-gray-400">{{ $item['label'] }}</p>
                            <p class="text-base font-semibold mt-1">{{ $item['value'] }}</p>
                        </div>
                    @endforeach

                    <div class="md:col-span-2">
                        <div class="bg-gray-700 rounded-xl p-4 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-1">Description</p>
                            <p class="text-sm text-gray-300">{{ $product->description ?? 'No Description.' }}</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                        <div class="bg-gray-700 rounded-xl p-4 border border-gray-600">
                            <p class="text-xs text-gray-400 mb-2">Image Product</p>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                    class="rounded-xl w-full max-w-md border border-gray-600">
                            @else
                                <p class="text-red-400">No Picture.</p>
                             @endif
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('product.manager') }}"
                       class="inline-flex items-center gap-2 px-5 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg shadow hover:bg-purple-700 transition">
                        ← Backs
                    </a>
                </div>
            </div>
        </div>
@endsection
