<?php include "../../views/admin/header.php";
require_once "../../app/Controller.php";
session_start();
$cars = $controller->Get("cars");
$slots = $controller->Get("slot_options");
$users = $controller->Get("users");
$bookings = $controller->Get("bookings");

?>

<style>
    h1,
    h2,
    h3 {
        font-weight: bold;
    }

    .h1 {
        font-size: 2.5rem;
    }

    #calendar {
        width: 100%;
        margin: 0 auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    td {
        width: 100px;
        height: 100px;
        border: 1px solid #ccc;
    }

    td:hover {
        background-color: #f2f2f2;
        cursor: pointer;
    }

    .prev-month,
    .next-month {
        cursor: pointer;
        font-weight: bold;
    }

    .has {
        background-color: red;
    }

    .today {
        background-color: #8686ff;
        color: white;
    }

    .today:hover {
        background-color: #6b6bee;
        color: white;
    }

    .disable {
        background-color: rgb(198, 198, 198);

    }

    .disable:hover {
        background-color: rgb(198, 198, 198);
        cursor: not-allowed;

    }

    #map {
        height: 400px;
        width: 100%;
    }
</style>
<link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
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

<?php foreach($cars as $car): ?>
    L.marker(["<?= $car["latitude"]?>" ,"<?= $car["longitude"]?>" ], { icon: 
        L.icon({
    iconUrl: "<?= $car["image"]?>",
    iconSize: [32, 32], // adjust the size of the icon
    iconAnchor: [16, 32], // adjust the position of the icon
})}).addTo(map)
    .bindPopup("<?= $car["name"]?>")
   



<?php endforeach; ?>






    var activeRoom = "Meeting Room";
    var parseDate = "";

    function handleRoomSelect(event) {
        // Remove active class from all link items
        var linkItems = document.querySelectorAll('.list-group-item');
        linkItems.forEach(function(item) {
            item.classList.remove('active');
        });
        activeRoom = event.target.innerHTML;
        // Add active class to the clicked link item
        var clickedElement = event.target;
        clickedElement.classList.add('active');
    }

    function handleAdd() {
        console.log(parseDate);
        // Create an object with the data to send in the request body
        let from = document.getElementById("timeFrom").value;
        let till = document.getElementById("timeTill").value;

        fetch("/app/Controller.php?dates=" + parseDate + "&room=" + activeRoom + '&time=' + from + "-" + till)
            .then(function(response) {
                if (response.ok) {
                    return response.json(); // If the response is JSON
                    // return response.text(); // If the response is plain text
                } else {
                    throw new Error('Error: ' + response.status);
                }
            })
            .then(function(data) {
                console.log('Response:', data);
                dates = data;
                // Handle the response data
            })
            .catch(function(error) {
                console.error('Error:', error);
                // Handle any errors that occurred during the request
            });
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

            // Previous month arrow
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

            // Next month arrow
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

            // Days of the week headers
            tr = document.createElement('tr');
            var daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            for (var i = 0; i < 7; i++) {
                var th = document.createElement('th');
                th.innerHTML = daysOfWeek[i];
                tr.appendChild(th);
            }
            table.appendChild(tr);

            // Calendar days
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

                            td.addEventListener('click', function() {
                                let dayElement = document.getElementById("modalDay");
                                let monthElement = document.getElementById("modalMonth");
                                let modalRoom = document.getElementById("modalRoom");
                                monthElement.textContent = getMonthName(month);
                                dayElement.textContent = this.innerHTML;
                                modalRoom.textContent = activeRoom;
                                parseDate = year + "-" + (month + 1) + "-" + this.innerHTML;

                                const myModal = new bootstrap.Modal('#bookingModal', {
                                    keyboard: false
                                })

                                myModal.show();

                            });
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSZpT8fIMzLCxM0AFnhDk7zTGPEI-vynI&callback=myMap"></script>