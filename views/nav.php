<div class="topnav">
    <a class="active" href="/">Home</a>

    <?php

    if (
        (isset($_SESSION["auth"]) && $_SESSION["auth"] === true)  &&
        (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
    ) { ?>
        <a href="/views/admin/booking.php">Bookings</a>
        <a href="/views/admin/newCar.php">Create car</a>
        <a href="/views/admin/slotAdmin.php">Manage Slots</a>
        <a href="/views/admin/carAdmin.php">Manage Cars</a>
    <?php } ?>
    <?php
    if (isset($_SESSION["auth"])) {
        echo "<a class=\"user\">{$_SESSION["userName"]}</a>";
        echo "<a href=\"/views/user/userBookings.php\">My Bookings</a>";
        echo "<a href=\"/views/signout.php\">signout</a>";
        $userName = $_SESSION["userName"];
        $userId = $_SESSION["userId"];
        $userEmail = $_SESSION["userEmail"];
    } else {
        echo "<a href=\"/views/login.php\">Login</a>";
        echo "<a href=\"/views/register.php\">Register</a>";
    }

    ?>
</div>