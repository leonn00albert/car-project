<?php require_once "../../app/Controller.php";
session_start();
if (

    (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
    (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
) {


?>

    <?php include "../../views/admin/header.php"; ?>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include "../../views/admin/navbar.php"; ?>
            <div class="col py-3 right-side-container">
                <div class="container">
                

       
                    <div class="card m-3 card-shadow">
                        <div class="card-body">
                        <h2>Bookings</h2>
                <table class="table">
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Car id
                        </th>
                        <th>
                            Car
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Date
                        </th>

                        <th>
                            Slot
                        </th>
                        <th>

                        </th>
                    </tr>
                    <?php
                    $bookings = $controller->Get("bookings");

                    foreach ($bookings as $booking) :
      
                        $booking["date"] = json_decode($booking["date"],true);
                        echo <<<EOD
                        <tr>
                            <td>{$booking["id"]}</td>
                            <td>{$booking["carId"]}</td>
                            <td>{$booking["car"]}</td>
                            <td>{$booking["name"]}</td>
                            <td>{$booking["date"]["date"]}</td>
                    EOD;
                        echo "<td>";
                        foreach ($booking["date"]["slots"] as $slot) {
                            if ($slot["available"] === false) {
                                echo $slot["name"];
                            }
                        }
                        echo "</td>";
                        echo "<td>
            <form action=\"/app/Controller.php\" method=\"POST\">
            <input type=\"hidden\" name=\"type\" value=\"bookings\" />
            <input type=\"hidden\" name=\"action\" value=\"delete\" />
                    <input type=\"hidden\" name=\"id\" value=\"{$booking["id"]}\" />
         <button type=\"submit\" class=\"btn btn-danger\">
      
            Delete</button>
                  </form>
 
                </tr>";
                    // add modal for delete and update
                    endforeach;
                    ?>
                </table>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>


<?php } else {
    header("location: /views/login.php");
} ?>
       
       

