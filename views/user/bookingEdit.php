<?php
session_start();
require_once "../../app/Controller.php";
include "../../views/header.php";
?>

<body>
    <div>

        <!-- Modal content -->
        <div class="modal-content">

            <p>
            <div class="container">
                <img />
                <h2> Book <span id="carName"></span></h2>
                <form method="POST" action="/app/Controller.php" id="myForm">
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="type" value="bookings" />
                    <input type="hidden" name="carId" id="carId" />
                    <input type="hidden" name="car" id="car" />

                    <input onchange="getSlots()" type="date" id="calendar" name="date" value="<?= $_GET["date"] ?>" required>

                    <?php
                    $slots = $controller->slots($_GET["date"], $_GET["carId"]);
                    if (!isset($slots[0]["name"])) {
                        echo "<p class=\"not-available\" >No Slots Available For This Day</p>";
                    } else {
                        echo "<select name=\"time\">";
                        foreach ($slots as $slot) :
                            echo "<option>{$slot["name"]}</option>";
                        endforeach;
                        echo "</select>";
                        echo "<button style=\"width: 100px\" type=\"submit\"> Reschedule </button>";
                    }

                    ?>
                </form>
            </div>
            </p>
        </div>
    </div>
</body>