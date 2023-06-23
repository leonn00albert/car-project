<?php include "../../views/admin/header.php";
require_once "../../app/Controller.php";
session_start();
$cars = $controller->Get("cars");
$slots = $controller->Get("slot_options");
$users = $controller->Get("users");
$bookings = $controller->Get("bookings");
if (
    (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
    (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
) {

?>

<style>

</style>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include "../../views/admin/navbar.php"; ?>
        <div class="col py-3 right-side-container">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card text-white bg-info card-shadow" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <h1><?= count($users) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-warning card-shadow" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Cars</h5>

                                <h1><?= count($cars) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-primary card-shadow" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Slots</h5>

                                <h1><?= count($slots) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-success card-shadow" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Bookings</h5>

                                <h1><?= count($bookings) ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-5 card-shadow">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>

                <div class="card m-5 card-shadow">
                    <div class="card-body">
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

    <?php foreach ($cars as $car) : ?>
        L.marker(["<?= $car["latitude"] ?>", "<?= $car["longitude"] ?>"], {
                icon: L.icon({
                    iconUrl: "<?= $car["image"] ?>",
                    iconSize: [32, 32],
                    iconAnchor: [16, 32], 
                })
            }).addTo(map)
            .bindPopup("<?= $car["name"] ?>")

    <?php endforeach; ?>

    var activeRoom = "Meeting Room";
    var parseDate = "";

    function handleRoomSelect(event) {
        var linkItems = document.querySelectorAll('.list-group-item');
        linkItems.forEach(function(item) {
            item.classList.remove('active');
        });
        activeRoom = event.target.innerHTML;
        var clickedElement = event.target;
        clickedElement.classList.add('active');
    }


    document.addEventListener('DOMContentLoaded', function() {
        var calendar = document.getElementById('calendar');

        var date = new Date();
        var currentMonth = date.getMonth();
        var currentYear = date.getFullYear();


        showCalendar(currentMonth, currentYear);

        function showCalendar(month, year) {
            var firstDay = (new Date(year, month)).getDay();
            var daysInMonth = 32 - new Date(year, month, 32).getDate();

            var table = document.createElement('table');
            var tr = document.createElement('tr');
            var prevMonth = document.createElement('th');

            prevMonth.classList.add('prev-month');
            prevMonth.innerHTML = '<';
            prevMonth.addEventListener('click', function() {
                if (month === 0) {
                    month = 11;
                    year -= 1;
                } else {
                    month -= 1;
                }
                showCalendar(month, year);
            });
            tr.appendChild(prevMonth);

            var monthText = document.createElement('th');
            monthText.setAttribute('colspan', '5');
            monthText.innerHTML = year + ' ' + getMonthName(month);
            tr.appendChild(monthText);

   
            var nextMonth = document.createElement('th');
            nextMonth.setAttribute('colspan', '7');
            nextMonth.classList.add('next-month');
            nextMonth.innerHTML = '>';
            nextMonth.addEventListener('click', function() {
                if (month === 11) {
                    month = 0;
                    year += 1;
                } else {
                    month += 1;
                }
                showCalendar(month, year);
            });
            tr.appendChild(nextMonth);

            table.appendChild(tr);

            tr = document.createElement('tr');
            var daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            for (var i = 0; i < 7; i++) {
                var th = document.createElement('th');
                th.innerHTML = daysOfWeek[i];
                tr.appendChild(th);
            }
            table.appendChild(tr);
            var day = 1;
            for (var i = 0; i < 6; i++) {
                tr = document.createElement('tr');
                for (var j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDay) {
                        var td = document.createElement('td');
                        td.classList.add('prev-month');
                        tr.appendChild(td);
                    } else if (day > daysInMonth) {
                        var td = document.createElement('td');
                        td.classList.add('next-month');
                        tr.appendChild(td);
                    } else {
                        var td = document.createElement('td');
                        let has = true;
                        td.innerHTML = day;

                        if ((day < new Date().getDate() && month <= new Date().getMonth()) || month < new Date().getMonth()) {
                            td.className = "disable";
                        } else {
                            let realMonth = month + 1;
                            let date = year + "-" + realMonth.toString().padStart(2, '0') + "-" + day.toString().padStart(2, '0');
                            let pElement = document.createElement("p");

                            <?php foreach($bookings as $booking): 
                                $date = json_decode($booking['date'],true);
                                ?>
                            if(date == "<?=$date['date']?>"){
                                pElement = document.createElement("p");
                                pElement.className = "calendar-car-item";
                                pElement.innerHTML = "<a href=\"/views/admin/booking-show.php?id=<?=$booking['id']?>\"><?=$booking['car']?></a>";
                                td.appendChild(pElement);
                            }

                            <?php endforeach;?>
                        }
                        if (day == new Date().getDate() && month == new Date().getMonth()) {
                            td.className = "today";
                        }

                        tr.appendChild(td);
                        day++;
                    }
                }
                table.appendChild(tr);
                if (day > daysInMonth) {
                    break;
                }
            }

            calendar.innerHTML = '';
            calendar.appendChild(table);
        }

        function getMonthName(month) {
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            return monthNames[month];
        }
    });
</script>

<?php include "footer.php";?>

<?php } else {
    header("location: /views/login.php");
} ?>
        