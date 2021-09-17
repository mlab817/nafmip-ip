@extends('layouts.app')

@section('content')
    <div id="map" style="min-height: 60vh;">
        <a href="{{ route('investments.create') }}" role="button" class="position-absolute btn" style="z-index: 999; top:0; right: 0; margin-top: 10px; margin-right: 10px;">New</a>
    </div>

    <div class="Box" style="max-height: 40vh; overflow: scroll;">
        @foreach($investments as $investment)
            <div class="Box-row d-flex flex-items-center">
                <div class="flex-auto">
                    <strong>{{ $investment->title }}</strong>
                    <div class="text-small color-text-tertiary">
                        {{ $investment->description }}
                    </div>
                </div>
                <a href="{{ route('investments.show', $investment) }}" class="btn btn-primary" role="button">View</a>
            </div>
        @endforeach
    </div>
@stop

@push('scripts')
    <script>
        const map = new L.Map('map', { zoom: 5, center: [11.9000, 121] });

        map.addLayer(new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'));	//base layer

        map.addControl( new L.Control.Search({
            url: 'https://nominatim.openstreetmap.org/search?format=json&q={s}&countrycodes=PH',
            jsonpParam: 'json_callback',
            propertyName: 'display_name',
            propertyLoc: ['lat','lon'],
            marker: L.circleMarker([0,0],{radius:30}),
            autoCollapse: false,
            autoType: false,
            minLength: 2
        }) );

        const markerLayer = L.layerGroup().addTo(map)

        axios.get('/api/investments?province=2')
            .then(res => {
                L.geoJSON(res.data.data, {
                    style: function (feature) {
                        return { color: feature.properties.color };
                    }
                }).bindPopup(function (layer) {
                    return layer.feature.properties.description;
                }).addTo(map);
            })
    </script>
@endpush
