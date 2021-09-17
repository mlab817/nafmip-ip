<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <link href="https://unpkg.com/@primer/css@^16.0.0/dist/primer.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.css" integrity="sha512-qI2MrOLvDIUkOYlIJTFwZbDQYEcuxaS8Dr4v+RIFz1LHL1KJEOKuO9UKpBBbKxfKzrnw9UB5WrGpdXQi0aAvSw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .search-input {
            font-family:Courier
        }
        .search-input,
        .leaflet-control-search {
            max-width:400px;
        }

        .leaflet-popup-content-wrapper {
            width: 100%;
        }

        .leaflet-container .leaflet-control-search {
            position:relative;
            float:left;
            background:#fff;
            color:#1978cf;
            border: 2px solid rgba(0,0,0,0.2);
            background-clip: padding-box;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.8);
            z-index:1000;
            margin-left: 10px;
            margin-top: 10px;
        }
        .leaflet-control-search.search-exp {/*expanded*/
            background: #fff;
            border: 2px solid rgba(0,0,0,0.2);
            background-clip: padding-box;
        }
        .leaflet-control-search .search-input {
            display:block;
            float:left;
            background: #fff;
            border:1px solid #666;
            border-radius:2px;
            height:22px;
            padding:0 20px 0 2px;
            margin:4px 0 4px 4px;
        }
        .leaflet-control-search.search-load .search-input {
            background: url('../images/loader.gif') no-repeat center right #fff;
        }
        .leaflet-control-search.search-load .search-cancel {
            visibility:hidden;
        }
        .leaflet-control-search .search-cancel {
            display:block;
            width:22px;
            height:22px;
            position:absolute;
            right:28px;
            margin:6px 0;
            background: url('../images/search-icon.png') no-repeat 0 -46px;
            text-decoration:none;
            filter: alpha(opacity=80);
            opacity: 0.8;
        }

        .leaflet-control-search .search-cancel:hover {
            filter: alpha(opacity=100);
            opacity: 1;
        }

        .leaflet-control-search .search-cancel span {
            display:none;/* comment for cancel button imageless */
            font-size:18px;
            line-height:20px;
            color:#ccc;
            font-weight:bold;
        }

        .leaflet-control-search .search-cancel:hover span {
            color:#aaa;
        }

        .leaflet-control-search .search-button {
            display:block;
            float:left;
            width:30px;
            height:30px;
            background: url('../images/search-icon.png') no-repeat 4px 4px #fff;
            border-radius:4px;
        }

        .leaflet-control-search .search-button:hover {
            background: url('../images/search-icon.png') no-repeat 4px -20px #fafafa;
        }

        .leaflet-control-search .search-tooltip {
            position:absolute;
            top:100%;
            left:0;
            float:left;
            list-style: none;
            padding-left: 0;
            min-width:120px;
            max-height:122px;
            box-shadow: 1px 1px 6px rgba(0,0,0,0.4);
            background-color: rgba(0, 0, 0, 0.25);
            z-index:1010;
            overflow-y:auto;
            overflow-x:hidden;
            cursor: pointer;
        }

        .leaflet-control-search .search-tip {
            margin:2px;
            padding:2px 4px;
            display:block;
            color:black;
            background: #eee;
            border-radius:.25em;
            text-decoration:none;
            white-space:nowrap;
            vertical-align:center;
        }

        .leaflet-control-search .search-button:hover {
            background-color: #f4f4f4;
        }

        .leaflet-control-search .search-tip-select,
        .leaflet-control-search .search-tip:hover {
            background-color: #fff;
        }

        .leaflet-control-search .search-alert {
            cursor:pointer;
            clear:both;
            font-size:.75em;
            margin-bottom:5px;
            padding:0 .25em;
            color:#e00;
            font-weight:bold;
            border-radius:.25em;
        }

        #map {
            max-height: 40vh;
        }
    </style>
</head>
<body>

<div id="map"></div>

<div class="d-flex flex-wrap">

    <div class="col-6 flex-column p-2">
        <dl class="form-group">
            <dt class="input-label">
                <label for="commodity_id">Commodity</label>
            </dt>
            <dd>
                <select name="commodity_id" id="commodity_id" class="form-select input-block"></select>
            </dd>
        </dl>

        <dl class="form-group">
            <dt class="input-label">
                <label for="title">Title</label>
            </dt>
            <dd>
                <input type="text" name="title" id="title" class="form-control input-block">
            </dd>
        </dl>

        <dl class="form-group">
            <dt class="input-label">
                <label for="description">Description</label>
            </dt>
            <dd>
                <textarea name="description" id="description" class="form-control input-block" rows="4"></textarea>
            </dd>
        </dl>

        <dl class="form-group">
            <dt class="input-label">
                <label for="intervention_id">Intervention</label>
            </dt>
            <dd>
                <select name="intervention_id" id="intervention_id" class="form-select input-block"></select>
            </dd>
        </dl>

        <dl class="form-group">
            <dt class="input-label">
                <label for="quantity">Quantity</label>
            </dt>
            <dd>
                <input type="number" name="quantity" id="quantity" class="form-control input-block">
            </dd>
        </dl>

        <dl class="form-group">
            <dt class="input-label">
                <label for="cost">Cost in PhP</label>
            </dt>
            <dd>
                <input type="number" name="cost" id="cost" class="form-control input-block">
            </dd>
        </dl>
    </div>

    <div class="col-6 flex-column p-2">
        <dl class="form-group">
            <dt class="input-label">
                <label for="proponent">Proponent</label>
            </dt>
            <dd>
                <input type="text" name="proponent" id="proponent" class="form-control input-block">
            </dd>
        </dl>

        <dl class="form-group">
            <dt class="input-label">
                <label for="beneficiaries">Beneficiaries</label>
            </dt>
            <dd>
                <input type="text" name="beneficiaries" id="beneficiaries" class="form-control input-block">
            </dd>
        </dl>

        <dl class="form-group">
            <dt class="input-label">
                <label for="location_map">Location Map <small> (select from the map)</small></label>
            </dt>
            <dd>
                <input type="text" name="location_map" id="location_map" class="form-control input-block" readonly>
            </dd>
        </dl>

        <dl class="form-group">
            <dt class="input-label">
                <label for="justification">Justification</label>
            </dt>
            <dd>
                <textarea name="justification" id="justification" class="form-control input-block" rows="4"></textarea>
            </dd>
        </dl>

        <button class="btn btn-primary">Submit</button>
    </div>

</div>

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
</body>
</html>
