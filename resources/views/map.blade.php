@extends('layout.template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <style>
        #map {
            width: 100%;
            height: calc(100vh - 56px);
            z-index: 0;
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>

    <!-- Modal create point -->
    <div class="modal fade" id="createpointModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Point</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('points.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill the name of the point">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geom_point" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geom_point" name="geom_point" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="image_point" name="image"
                                onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-point" class="img-thumbnail"
                                width="400">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal create polyline -->
    <div class="modal fade" id="createpolylineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Polyline</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('polylines.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill the name of the polyline">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geom_polyline" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geom_polyline" name="geom_polyline" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="image_polyline" name="image"
                                onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-polyline" class="img-thumbnail"
                                width="400">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal create polygon -->
    <div class="modal fade" id="createpolygonModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Polygon</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('polygons.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill the name of the polygon">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geom_polygon" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geom_polygon" name="geom_polygon" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="image_polygon" name="image"
                                onchange="document.getElementById('preview-image-polygon').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-polygon" class="img-thumbnail"
                                width="400">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>
    <script>
        window.onload = function() {
            var map = L.map('map').setView([-6.9235068, 107.6028442], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            var drawControl = new L.Control.Draw({
                draw: {
                    position: 'topleft',
                    polyline: true,
                    polygon: true,
                    rectangle: true,
                    circle: false,
                    marker: true,
                    circlemarker: false
                },
                edit: false
            });

            map.addControl(drawControl);

            map.on('draw:created', function(e) {
                var type = e.layerType,
                    layer = e.layer;

                var drawnJSONObject = layer.toGeoJSON();
                var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

                if (type === 'polyline') {
                    $('#geom_polyline').val(objectGeometry);
                    $('#createpolylineModal').modal('show');
                } else if (type === 'polygon' || type === 'rectangle') {
                    $('#geom_polygon').val(objectGeometry);
                    $('#createpolygonModal').modal('show');
                } else if (type === 'marker') {
                    $('#geom_point').val(objectGeometry);
                    $('#createpointModal').modal('show');
                }

                drawnItems.addLayer(layer);
            });

            // Load Point GeoJSON
            var point = L.geoJson(null, {
                onEachFeature: function(feature, layer) {

                    var routeDelete = "{{ route('points.destroy', ':id') }}";
                    routeDelete = routeDelete.replace(':id', feature.properties.id);


                    var routeedit = "{{ route('points.edit', ':id') }}";
                    routeedit = routeedit.replace(':id', feature.properties.id);

                    var popupContent = "Nama: " + feature.properties.name + "<br>" +
                        "Deskripsi: " + feature.properties.description + "<br>" +
                        "Dibuat pada: " + feature.properties.created_at + "<br>" +
                        "<img src='{{ asset('storage/images') }}/" + feature.properties.image +
                        "' width='200' alt=''>" + "<br>" +
                        "<a href='" + routeedit +
                        "' class='btn btn-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a>" +
                        "<form method='POST' action='" + routeDelete + "'>" +
                        '@csrf' + '@method('DELETE')' +
                        "<button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(`Are you sure?`)'><i class='fa-solid fa-trash-can'></i></button>" +
                        "</form>" +
                        "</div>" + "<br>" + "<p>Dibuat Oleh: " + feature.properties.user_created + "</p>";

                    layer.on({
                        click: function() {
                            layer.bindPopup(popupContent).openPopup();
                        },
                        mouseover: function() {
                            layer.bindTooltip(feature.properties.name);
                        },
                    });
                },
            });
            $.getJSON("{{ route('api.points') }}", function(data) {
                point.addData(data);
                map.addLayer(point);
            });

            // Load Polyline GeoJSON
            var polylines = L.geoJson(null, {
                onEachFeature: function(feature, layer) {

                    var routeDelete = "{{ route('polylines.destroy', ':id') }}";
                    routeDelete = routeDelete.replace(':id', feature.properties.id);

                    var routeedit = "{{ route('polylines.edit', ':id') }}";
                    routeedit = routeedit.replace(':id', feature.properties.id);


                    var popupContent = "Nama: " + feature.properties.name + "<br>" +
                        "Deskripsi: " + feature.properties.description + "<br>" +
                        "Panjang: " + feature.properties.length_km.toFixed(2) + " km<br>" +
                        "Dibuat: " + feature.properties.created_at + "<br>" +
                        "<img src='{{ asset('storage/images') }}/" + feature.properties.image +
                        "' width='200' alt=''>" + "<br>" +
                        "<a href='" + routeedit +
                        "' class='btn btn-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a>" +
                        "<form method='POST' action='" + routeDelete + "'>" +
                        '@csrf' + '@method('DELETE')' +
                        "<button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(`Are you sure?`)'><i class='fa-solid fa-trash-can'></i></button>" +
                        "</form>" + "</div>" + "<br>" + "<p>Dibuat Oleh: " + feature.properties.user_created + "</p>";
                    layer.on({
                        click: function() {
                            layer.bindPopup(popupContent).openPopup();
                        },
                        mouseover: function() {
                            layer.bindTooltip(feature.properties.name);
                        },
                    });
                },
            });
            $.getJSON("{{ route('api.polylines') }}", function(data) {
                polylines.addData(data);
                map.addLayer(polylines);
            });

            // Load Polygon GeoJSONS
            var polygons = L.geoJson(null, {
                onEachFeature: function(feature, layer) {
                    var routeDelete = "{{ route('polygons.destroy', ':id') }}";
                    routeDelete = routeDelete.replace(':id', feature.properties.id);

                    var routeedit = "{{ route('polygons.edit', ':id') }}";
                    routeedit = routeedit.replace(':id', feature.properties.id);

                    var popupContent = "Nama: " + feature.properties.name + "<br>" +
                        "Deskripsi: " + feature.properties.description + "<br>" +
                        "Luas: " + feature.properties.area_km2.toFixed(2) + " km<sup>2</sup><br>" +
                        "Dibuat: " + feature.properties.created_at + "<br>" +
                        "<img src='{{ asset('storage/images') }}/" + feature.properties.image +
                        "' width='200' alt=''>" + "<br>" +
                        "<a href='" + routeedit +
                        "' class='btn btn-warning btn-sm'><i class='fa-solid fa-pen-to-square'></i></a>" +
                        "<form method='POST' action='" + routeDelete + "'>" +
                        '@csrf' + '@method('DELETE')' +
                        "<button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(`Are you sure?`)'><i class='fa-solid fa-trash-can'></i></button>" +
                        "</form>"+"</div>" + "<br>" + "<p>Dibuat Oleh: " + feature.properties.user_created + "</p>";
                    layer.on({
                        click: function() {
                            layer.bindPopup(popupContent).openPopup();
                        },
                        mouseover: function() {
                            layer.bindTooltip(feature.properties.name);

                        },
                    });
                },
            });
            $.getJSON("{{ route('api.polygons') }}", function(data) {
                polygons.addData(data);
                map.addLayer(polygons);
            });
        };
    </script>
@endsection
