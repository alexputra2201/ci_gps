<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>

    <script src="https://unpkg.com/esri-leaflet@3.0.7/dist/esri-leaflet.js"
        integrity="sha512-ciMHuVIB6ijbjTyEdmy1lfLtBwt0tEHZGhKVXDzW7v7hXOe+Fo3UA1zfydjCLZ0/vLacHkwSARXB5DmtNaoL/g=="
        crossorigin=""></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
    #map {
        height: 500px;
    }
    </style>
</head>

<body>
    <div id="map"></div>
</body>

<script>
$(document).ready(function() {
    const btnInsert = $('#btnInsertData');
    var iconMarker = null;
    var startLatLng = null;
    var endLatLng = null;

    var map = L.map('map').setView([0.514574, 101.419746], 17);

    L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);


    var iconLocation = L.icon({
        iconUrl: 'assets/location.png',
        iconSize: [64, 64],
    });



    function init() {
        $.ajax({
            url: '<?= base_url('map/get_data'); ?>',
            method: 'GET',
            dataType: 'JSON',
        }).done(function(res) {

            // console.log(res.length == 0);
            if (res.length == 0) {
                return;
            }

            var startLatLng = res[0];
            var endLatLng = res.length - 1;

            var response = res;
            var newArr = [];

            for (var i = 0; i < response.length; i++) {
                newArr.push([response[i].lat, response[i].lng]);
            }

            L.polyline(newArr, {
                color: 'red'
            }).addTo(map);



            if (iconMarker === null) {
                iconMarker = L.marker([res[endLatLng].lat, res[endLatLng].lng], {
                    icon: iconLocation
                }).addTo(map);
            } else {
                iconMarker.setLatLng([res[endLatLng].lat, res[endLatLng].lng]);
            }

        });
    }

    init();

    setInterval(init, 1000);
    $(function() {
        init();
    });


    btnInsert.on('click', function(e) {
        e.preventDefault();


        $.ajax({
            url: '<?= base_url('assets/data.json'); ?>',
            method: 'POST',
            dataType: 'JSON',

        }).done(function(res) {

            $.each(res.data, function(index, item) {
                setTimeout(function() {

                    insertToDB(item);
                }, index * 3000);
            });

        })
    });



    function insertToDB(item) {
        item = item;

        $.ajax({
            url: '<?= base_url('map/proses_save'); ?>',
            method: 'POST',
            data: {
                item: item
            },
        }).done(function(res) {
            console.log(res);
        });
    }

});
</script>

</html>