<?php require_once "../../app/Controller.php";
session_start();
if (

    (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
    (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
) {


?>

    <html lang="en">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                        <svg class="bi me-2" width="40" height="32">
                            <use xlink:href="#bootstrap"></use>
                        </svg>
                        <span class="fs-4">Admin</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="/" class="nav-link" aria-current="page">

                                Home
                            </a>
                        </li>
                        <li>
                            <a href="/views/admin/carAdmin.php" class="nav-link " aria-current="page">

                                Cars
                            </a>
                        </li>
                        <li>
                            <a href="/views/admin/booking.php" class="nav-link" aria-current="page">

                                Bookings
                            </a>
                        </li>
                        <li>
                            <a href="/views/admin/slotAdmin.php" class="nav-link active" aria-current="page">
                                Slots
                            </a>
                        </li>
                        <li>
                            <a href="/views/admin/userAdmin.php" class="nav-link" aria-current="page">

                                Users
                            </a>
                        </li>
                        <li>
                            <a href="/views/signout.php" class="nav-link" aria-current="page">

                                Signout
                            </a>
                        </li>
                    </ul>
                    <hr>

                </div>

                <div class="col-sm">
                    <h2>Slots</h2>
                    <h5>Create Slot</h5>
                    <form method="POST" action="/app/Controller.php" style="width: 30%; margin: 0 auto;">
                        <input type="hidden" name="action" value="create" />
                        <input type="hidden" name="type" value="slot" />
                        <input type="text" name="name" placeholder="time" />
                        <input type="submit" value="submit" />
                    </form>
                    <table class="table">
                        <tr>
                            <th>
                                ID
                            </th>

                            <th>
                                Name
                            </th>
                            <th>

                            </th>
                            <?php
                            $slots = $controller->Get("slot_options");
                            foreach ($slots as $slot) :
                                echo <<<EOD
                  <tr>
                    <td>{$slot["id"]}</td>
                    <td>{$slot["name"]}</td>
          
             EOD;

                                echo "<td>
            <form action=\"/app/Controller.php\" method=\"POST\">
            <input type=\"hidden\" name=\"type\" value=\"slot\" />
            <input type=\"hidden\" name=\"action\" value=\"delete\" />
                    <input type=\"hidden\" name=\"id\" value=\"{$slot["id"]}\" />
   <button type=\"submit\" class=\"btn btn-danger\">      
            Delete</button>
                  </form>
            <a href=\"slotEdit.php?id={$slot["id"]}\">Update</a></td>";
                                echo "</tr>";
                            // add modal for delete and update
                            endforeach;
                            ?>
                    </table>

                </div>
            </div>
        </div>

        <body>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

        </body>

    </html>
<?php } else {
    header("location: login.php");
} ?>