@extends('layouts.app')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection
@section('main')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <img src="{{getQRImageURL()}}" class="mx-auto qr-css" alt=""/>
                    <h3 class="text-center qr-text">Here is your QR, you can share it with anyone.</h3>
                    <a href="{{route('regenerate-qr')}}" class="btn btn-outline-primary mt-4">Regenerate QR Code</a>
                </div>
            </div>
        </div>
    </div>
@endsection
