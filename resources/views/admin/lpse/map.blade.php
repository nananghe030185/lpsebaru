@php
    $asset = asset('assets/');
@endphp
@extends('layouts.admin.master')

@section('title', 'Map')

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/leaflet.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/leaflet/L.switchBasemap.css') }}">
    <style>
        .leaflet-map{
            width: 100%;
            height: 70vh;
        }
    </style>
@endsection

@section('main_content')
    <!-- Bradcrumb -->
    <x-breadcrumb>Map</x-breadcrumb>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.lpse.index')}}" class="btn btn-info btn-sm"><span class="fa fa-table"></span> Tabel</a>
                    </div>
                    <div class="card-body">
                        <div id="map" class="leaflet-map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet/leaflet.ajax.min.js') }}"></script>
    <script src="{{ asset('assets/js/leaflet/L.switchBasemap.js') }}"></script>
    <script>
        const map = L.map('map', {
            minZoom: 1,
            maxZoom:28
            // fullscreenControl: true,
        }).setView([-0.5884941, 119.1257271], 5);

        new L.basemapsSwitcher([
        {
            layer: L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                maxZoom: 30,
                subdomains:['mt0','mt1','mt2','mt3']
            }).addTo(map),
            icon: '{{ $asset }}' +  '/images/basemap/google.png',
            name: 'Google Maps'
        },
        {
            layer: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles \u0026copy; Esri',
            maxZoom: 30,
            }),
            icon: '{{ $asset }}' +  '/images/basemap/esri.png',
            name: 'Esri'
        },
        {
            layer: L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png',{
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 30,
            }),
            icon: '{{ $asset }}' +  '/images/basemap/osm.png',
            name: 'OSM'
        }
        ], { position: 'bottomleft' }).addTo(map);

        // L.geoJSON.ajax(baseUrl + 'assets/map/papua.json').addTo(map);
        // L.geoJSON.ajax(baseUrl + 'assets/map/balinusra.json').addTo(map);
        // L.geoJSON.ajax(baseUrl + 'assets/map/kalimantan.json').addTo(map);
        // L.geoJSON.ajax(baseUrl + 'assets/map/maluku.json').addTo(map);
        // L.geoJSON.ajax(baseUrl + 'assets/map/sulawesi.json').addTo(map);
        // L.geoJSON.ajax(baseUrl + 'assets/map/sumatera.json').addTo(map);
        // L.geoJSON.ajax(baseUrl + 'assets/map/jawa.json').addTo(map);
        L.geoJSON.ajax(baseUrl + 'assets/map/provinsi.json').addTo(map);
    </script>
@endsection