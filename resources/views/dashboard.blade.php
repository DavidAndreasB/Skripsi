@extends('layouts.app')

@section('content')


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">Selamat datang di PT Venus Tekindo!</h3>
                <p class="mt-2 text-gray-600">
                    Gunakan menu di samping untuk mengelola Surat Perintah Kerja (SPK), Job Sheet, atau Pengaturan sistem.
                </p>
            </div>
        </div>
    </div>



@endsection

