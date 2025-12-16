@extends('layouts.app')

@section('title','prayer-space')

@section('content')

<div class="container my-4">

    <div class="container">
        <div id="prayer-times" class="card"></div>

<head>
    <title>Prayer Space</title>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-bhE4I0DztxxytLEdJO2JNWsLL8NS4l8&libraries=places"></script>
</head>
<body>
    <h1>Prayer Space</h1>
    <div id="prayer-times" class="card"></div>
            <h2>Prayer Times</h2>
            <ul>
                <li>Fajr: <span id="fajr"></span></li>
                <li>Dhuhr: <span id="dhuhr"></span></li>
                <li>Asr: <span id="asr"></span></li>
                <li>Maghrib: <span id="maghrib"></span></li>
                <li>Isha: <span id="isha"></span></li>
            </ul>
        </div>


        <div id="qibla-finder">
            <h2>Qibla Finder</h2>
            <p id="qibla">Qibla Direction: Loading...</p>
            <div id="qibla-compass" style="position: relative; width: 150px; height: 150px; margin: auto;">
                <img
                    src="frontend/images/compass bg.jpeg"
                    alt="Compass background"
                    style="width: 100%; height: 100%; position: absolute; z-index: 1;"
                />
                <img
                    id="qibla-compass-arrow"
                    src="frontend/images/arrow.jpeg"
                    alt="Compass arrow"
                    style="width: 50px; height: 50px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(0deg); z-index: 2;"
                />
            </div>
        </div>



    <!-- map -->
    <h2>Nearby Mosque</h2>
    <div id="map"
     style="width: 100%; height: 400px;"></div>

    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">Back</a>

    <script>
        // Check if Geolocation is available
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    // Log user's location
                    console.log("Latitude: " + lat + ", Longitude: " + lon);

                    // Fetch prayer times
                    fetchPrayerTimes(lat, lon);

                    // Fetch Qibla direction and update compass
                    fetchQibla(lat, lon);

                    // Initialize the map with mosques
                    initMap(lat, lon);
                },
                (error) => {
                    console.error("Error fetching location:", error);
                    alert("Unable to fetch your location.");
                }
            );
        } else {
            alert("Geolocation is not supported by this browser.");
        }

        // Fetch Prayer Times
        async function fetchPrayerTimes(lat, lon) {
            try {
                const response = await fetch(
                    `https://api.aladhan.com/v1/timings/16-01-2025?latitude=3.236497&longitude=101.710922&method=17&shafaq=general&tune=5%2C3%2C5%2C7%2C9%2C-1%2C0%2C8%2C-6&school=0&midnightMode=1&timezonestring=UTC&calendarMethod=UAQ
`
                );
                const data = await response.json();
                console.log(data);

                // Display prayer times
                document.getElementById("fajr").textContent = data.data.timings.Fajr;
                document.getElementById("dhuhr").textContent =
                    data.data.timings.Dhuhr;
                document.getElementById("asr").textContent = data.data.timings.Asr;
                document.getElementById("maghrib").textContent =
                    data.data.timings.Maghrib;
                document.getElementById("isha").textContent = data.data.timings.Isha;
            } catch (error) {
                console.error("Error fetching prayer times:", error);
            }
        }

        // Fetch Qibla Direction and Update Compass
        async function fetchQibla(lat, lon) {
            try {
                const response = await fetch(
                    `https://api.aladhan.com/v1/qibla/${3.236497}/${101.710922}`
                );
                const data = await response.json();
                console.log(data);

                // Display Qibla direction
                const direction = data.data.direction; // Qibla direction in degrees
                document.getElementById("qibla").textContent = Qibla Direction: ${qiblaDirection.toFixed(2)}°;

                // Update the Qibla compass dynamically using the device orientation API
                if (window.DeviceOrientationEvent) {
                    window.addEventListener("deviceorientation", (event) => {
                        const compassHeading = event.alpha; // Device heading in degrees
                        const adjustedDirection = (qiblaDirection - compassHeading + 360) % 360;

                        const compassArrow = document.getElementById("qibla-compass-arrow");
                        compassArrow.style.transform = translate(-50%, -50%) rotate(${adjustedDirection}deg);
                    });
                } else {
                    alert("Your device does not support compass functionality.");
                }
            } catch (error) {
                console.error("Error fetching Qibla direction:", error);
            }
        }

        // Display mosques on Google Maps
        function initMap(lat, lon) {
            const userLocation = { lat: lat, lng: lon };
            const map = new google.maps.Map(document.getElementById("map"), {
                center: userLocation,
                zoom: 15,
            });

            const service = new google.maps.places.PlacesService(map);
            service.nearbySearch(
                {
                    location: userLocation,
                    radius: 5000,
                    keyword: "mosque",
                },
                (results, status) => {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        results.forEach((place) => {
                            new google.maps.Marker({
                                position: place.geometry.location,
                                map: map,
                                title: place.name,
                            });
                        });
                    }
                }
            );
        }
    </script>


</body>
@endsection
