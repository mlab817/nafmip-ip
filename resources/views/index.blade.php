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

        #map {
            height: 100vh;
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
            height: 100vh;
        }
    </style>
</head>
<body>
<div id="map"></div>
<div class="form p-5">
    <dl>
        <dt class="input-label">
            <label for="title">Title</label>
        </dt>
        <dd>
            <input type="text" name="title" class="form-control input-block">
        </dd>
    </dl>

    <dl>
        <dt class="input-label">
            <label for="description">Description</label>
        </dt>
        <dd>
            <textarea name="description" id="description" class="form-control input-block"></textarea>
        </dd>
    </dl>

    <dl>
        <dt class="input-label">
            <label for="cost">Cost in PhP</label>
        </dt>
        <dd>
            <input type="number" name="cost" id="cost" class="form-control input-block">
        </dd>
    </dl>

</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js" integrity="sha512-lmt2nQGwuhA/7xEG4KjOuzy+kBQVOgpBNFxJR2yWp8J57H8nYxWC8J7Y5woDbqBBpBVHHLbFEi503u5K49KcOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var map = new L.Map('map', {zoom: 6, center: new L.latLng([12.505,121.002411]) });
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
        document.getElementById('title').value = JSON.stringify(e.latlng)
    })
</script>
</body>
</html>
