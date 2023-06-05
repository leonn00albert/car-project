<?php
session_start();
require_once "../../app/Controller.php"; ?>
<!doctype html>
<html lang="en">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
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
                    <a href="/views/admin/carAdmin.php" class="nav-link active" aria-current="page">

                        Cars
                    </a>
                </li>
                <li>
                    <a href="/views/admin/booking.php" class="nav-link" aria-current="page">

                        Bookings
                    </a>
                </li>
                <li>
                    <a href="/views/admin/slotAdmin.php" class="nav-link" aria-current="page">
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
            <h2>Cars</h2>
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
                </tr>
                <?php
                $cars = $controller->Get("cars");
                foreach ($cars as $car) :
                    echo <<<EOD
                  <tr>
                    <td>{$car["id"]}</td>
                    <td>{$car["name"]}</td>
           
             EOD;

                    echo "<td>
            <form action=\"/app/Controller.php\" method=\"POST\">
            <input type=\"hidden\" name=\"type\" value=\"cars\" />
            <input type=\"hidden\" name=\"action\" value=\"delete\" />
                    <input type=\"hidden\" name=\"id\" value=\"{$car["id"]}\" />
   <button type=\"submit\" class=\"btn btn-danger\">      
            Delete</button>
                  </form>
            <a href=\"carEdit.php?id={$car["id"]}\">Update</a></td>";
                    echo "</tr>";
                // add modal for delete and update
                endforeach;
                ?>
            </table>

        </div>
    </div>
</div>

</html>