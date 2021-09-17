@extends('layouts.app')

@section('content')
    <div id="map" style="min-height: 50vh;"></div>

    <form action="{{ route('investments.store') }}" accept-charset="UTF-8" method="POST">
        @csrf
        @method('POST')
        <div class="d-flex flex-wrap">

            <div class="col-6 flex-column p-2">
                <dl class="form-group @error('commodity_id') errored @enderror">
                    <dt class="input-label">
                        <label for="commodity_id">Commodity</label>
                    </dt>
                    <dd>
                        <select name="commodity_id" id="commodity_id" class="form-select input-block">
                            @foreach($commodityTypes as $commodityType)
                                <optgroup label="{{ $commodityType->name }}"></optgroup>
                                @foreach($commodityType->commodities as $commodity)
                                    <option value="{{ $commodity->id }}" @if(old('commodity_id') == $commodity->id) selected @endif>{{ $commodity->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </dd>
                </dl>

                <dl class="form-group @error('title') errored @enderror">
                    <dt class="input-label">
                        <label for="title">Title</label>
                    </dt>
                    <dd>
                        <input type="text" name="title" id="title" class="form-control input-block" value="{{ old('title') }}">
                    </dd>
                </dl>

                <dl class="form-group @error('description') errored @enderror">
                    <dt class="input-label">
                        <label for="description">Description</label>
                    </dt>
                    <dd>
                        <textarea name="description" id="description" class="form-control input-block" rows="4">{{ old('description') }}</textarea>
                    </dd>
                </dl>

                <dl class="form-group @error('intervention_id') errored @enderror">
                    <dt class="input-label">
                        <label for="intervention_id">Intervention</label>
                    </dt>
                    <dd>
                        <select name="intervention_id" id="intervention_id" class="form-select input-block">
                            @foreach($investmentTypes as $investmentType)
                                <optgroup label="{{ $investmentType->name }}"></optgroup>
                                @foreach($investmentType->interventions as $intervention)
                                    <option value="{{ $intervention->id }}"  @if(old('intervention_id') == $intervention->id) selected @endif>{{ $intervention->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </dd>
                </dl>

                <dl class="form-group @error('quantity') errored @enderror">
                    <dt class="input-label">
                        <label for="quantity">Quantity</label>
                    </dt>
                    <dd>
                        <input type="number" name="quantity" id="quantity" class="form-control input-block" value="{{ old('quantity') }}">
                    </dd>
                </dl>

                <dl class="form-group @error('cost') errored @enderror">
                    <dt class="input-label">
                        <label for="cost">Cost in PhP</label>
                    </dt>
                    <dd>
                        <input type="number" name="cost" id="cost" class="form-control input-block" value="{{ old('cost') }}">
                    </dd>
                </dl>
            </div>

            <div class="col-6 flex-column p-2">
                <dl class="form-group @error('proponent') errored @enderror">
                    <dt class="input-label">
                        <label for="proponent">Proponent</label>
                    </dt>
                    <dd>
                        <input type="text" name="proponent" id="proponent" class="form-control input-block" value="{{ old('proponent') }}">
                    </dd>
                </dl>

                <dl class="form-group @error('beneficiaries') errored @enderror">
                    <dt class="input-label">
                        <label for="beneficiaries">Beneficiaries</label>
                    </dt>
                    <dd>
                        <input type="text" name="beneficiaries" id="beneficiaries" class="form-control input-block" value="{{ old('beneficiaries') }}">
                    </dd>
                </dl>

                <dl class="form-group @error('location_map') errored @enderror">
                    <dt class="input-label">
                        <label for="location_map">Location Map <small> (select from the map)</small></label>
                    </dt>
                    <dd>
                        <input type="text" name="location_map" id="location_map" class="form-control input-block" readonly value="{{ old('location_map') }}">
                    </dd>
                </dl>

                <dl class="form-group @error('justification') errored @enderror">
                    <dt class="input-label">
                        <label for="justification">Justification</label>
                    </dt>
                    <dd>
                        <textarea name="justification" id="justification" class="form-control input-block" rows="4">
                            {{ old('justification') }}
                        </textarea>
                    </dd>
                </dl>

                <button class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>
@stop

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js" integrity="sha512-lmt2nQGwuhA/7xEG4KjOuzy+kBQVOgpBNFxJR2yWp8J57H8nYxWC8J7Y5woDbqBBpBVHHLbFEi503u5K49KcOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function getCurrentLocation(callback) {
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    callback(new L.LatLng(position.coords.latitude,
                        position.coords.longitude));
                });
            }
            else {
                throw new Error("Your browser does not support geolocation.");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            getCurrentLocation(function (location) {
                if (!location) {
                    location = new L.latLng([12.505, 121.002411]);
                }

                const map = new L.Map('map', { zoom: 12, center: location });

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

                map.doubleClickZoom.disable()

                const layerGroup = L.layerGroup().addTo(map);

                map.on('dblclick', function(e) {
                    layerGroup.clearLayers()
                    marker = L.marker(e.latlng)
                    marker.addTo(layerGroup)
                    document.getElementById('location_map').value = JSON.stringify(e.latlng)
                })

                L.popup()
                    .setLatLng(location)
                    .setContent('current location')
                    .openOn(map);
            });
        });
    </script>
@endpush
