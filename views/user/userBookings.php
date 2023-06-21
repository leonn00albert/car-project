<?php
require_once "../../app/Controller.php";
session_start();
if (isset($_SESSION["auth"]) && $_SESSION["auth"] == true) {
    include "../../views/header.php";
?>

    <!DOCTYPE html>
    <html>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>

    <body>
        <div class="page-container">
            <?php include "../../views/nav.php"; ?>
            <h2 class="text-center my-5 text-white">Bookings</h2>
            <div class="card rounded p-4 bg-dark fluid" style="width: 70%;margin: 0 auto;">
                <table class="table container table-dark rounded">
                    <tr>
                        <th>Car</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Slot</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php

                    $bookings = $controller->Get("userBookings", $userId);

                    foreach ($bookings as $booking) {
                        $booking["date"] = json_decode($booking["date"], true);
                    ?>

                        <tr>
                            <td><?php echo $booking["car"]; ?></td>
                            <td><?php echo $booking["name"]; ?></td>
                            <td><?php echo $booking["date"]["date"]; ?></td>
                            <td>
                                <?php
                                foreach ($booking["date"]["slots"] as $slot) {
                                    if ($slot["available"] === false) {
                                        echo $slot["name"];
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <form action="/app/Controller.php" method="POST">
                                    <input type="hidden" name="type" value="bookings" />
                                    <input type="hidden" name="action" value="delete" />
                                    <input type="hidden" name="id" value="<?php echo $booking["id"]; ?>" />
                                    <button type="submit">Cancel</button>
                                </form>
                            </td>
                            <td>
                                <a class="reschedule-button" type="button" href="#" data-bs-toggle="modal" data-bs-target="#<?php echo $booking["id"]; ?>model">Reschedule</a>
                            </td>
                            <td>
                                <a class="reschedule-button" href="reviews.php?carId=<?php echo $booking["carId"]; ?>&car=<?php echo $booking["car"]; ?>">Review</a>
                            </td>
                        </tr>

                        <div id="<?php echo $booking["id"]; ?>model" class="modal">
                            <div class="modal-dialog modal-lg">
                                <p>
                                <div class="container modal-content">

                                    <div class="modal-header">
                                        <h3 class="text-white">Reschedule the booking for <span id="carName"><?php echo $booking["car"]; ?></span></h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form method="POST" action="/app/Controller.php" id="myForm">
                                        <input type="hidden" name="action" value="update" />
                                        <input type="hidden" name="type" value="bookings" />
                                        <input type="hidden" name="carid" value="<?php echo $booking["carId"]; ?>" />
                                        <input type="hidden" name="bookingId" value="<?php echo $booking["id"]; ?>" />
                                        <input onchange="getSlots()" type="date" id="calendar" name="date" value="<?php echo $booking["date"]["date"]; ?>" required>

                                        <?php
                                        $slots = $controller->slots($booking["date"]["date"], $booking["carId"]);
                                        if (!isset($slots[0]["name"])) {
                                            echo '<p class="not-available">No Slots Available For This Day</p>';
                                        } else {
                                            echo '<select name="time">';
                                            foreach ($slots as $slot) {
                                                echo '<option>' . $slot["name"] . '</option>';
                                            }
                                            echo '</select>';
                                            echo '<button style="width: 150px" type="submit" class="mt-4">Reschedule</button>';
                                        }
                                        ?>

                                    </form>
                                </div>
                                </p>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                </table>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="../../static/main.js"></script>
    </body>

    </html>

<?php
}
?>