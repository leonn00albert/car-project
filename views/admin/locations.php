<?php require_once "../../app/Controller.php";
session_start();
if (

    (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
    (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
) {

    $cars = $controller->Get("cars");
?>

    <?php include "../../views/admin/header.php"; ?>
    
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include "../../views/admin/navbar.php"; ?>
            <div class="col py-3 right-side-container">
                <div class="container">
                    <div class="card m-3 card-shadow">
                        <div class="card-body">
                        <h2>Car Locations</h2>
           
                        <div id="map"></div>

                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([51.505, -0.09], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 4,
    }).addTo(map);

<?php foreach($cars as $car): ?>
    L.marker(["<?= $car["latitude"]?>" ,"<?= $car["longitude"]?>" ], { icon: 
        L.icon({
    iconUrl: "<?= $car["image"]?>",
    iconSize: [32, 32], // adjust the size of the icon
    iconAnchor: [16, 32], // adjust the position of the icon
})}).addTo(map)
    .bindPopup("<?= $car["name"]?>")

    <?php endforeach; ?>
</script>

<?php } else {
    header("location: /views/login.php");
} ?>
        