@extends('layouts.dashboard')

@section('content')
    <div class="p-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
        <div class="w-full mb-4">
            {{-- Breadcrumb --}}
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>
                        <a href="#" class="inline-flex items-center hover:text-primary-500">
                            <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-400">Settings</span>
                    </li>
                </ol>
            </nav>

            {{-- Heading --}}
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Application Setting</h1>

            {{-- Form --}}
            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- App Title --}}
                <div>
                    <label for="app_title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                        Aplikasi</label>
                    <input type="text" name="app_title" id="app_title"
                        value="{{ old('app_title', $settings['app_title'] ?? '') }}"
                        class="mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:outline-none"
                        required>
                </div>

                {{-- Logo Upload --}}
                <div>
                    <label for="app_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Logo
                        Aplikasi</label>
                    @if (!empty($settings['app_logo']))
                        <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="Logo"
                            class="h-12 w-12 rounded object-cover border border-gray-300 dark:border-gray-600 mb-2">
                    @else
                        <p class="text-sm text-gray-400">Belum ada logo</p>
                    @endif
                    <input type="file" name="app_logo" id="app_logo"
                        class="mt-2 block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-600 file:text-white hover:file:bg-primary-700">
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 rounded-lg dark:bg-primary-500 dark:hover:bg-primary-600 dark:focus:ring-primary-800">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection