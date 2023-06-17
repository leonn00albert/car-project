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
                    <div class="row">
                        <div class="col">
                            <div class="card m-3 card-shadow">
                                <div class="card-body">
                                    <h2>Slots</h2>
                                    <h5>Create Slot</h5>
                                    <?php include "../../views/admin/newCar.php"; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">

                            <div class="card m-3 card-shadow">
                                <div class="card-body">
                                    <h2>Cars</h2>
                                    <table class="table">
                                        <tr>
                                            <th>

                                            </th>
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
                  <td><img class="table-avatar" src={$car["image"]} /></td>
                    <td>{$car["id"]}</td>
                    <td>{$car["name"]}</td>
           
             EOD;

                                            echo "<td>
            <form action=\"/app/Controller.php\" method=\"POST\">
            <input type=\"hidden\" name=\"type\" value=\"cars\" />
            <input type=\"hidden\" name=\"action\" value=\"delete\" />
                    <input type=\"hidden\" name=\"id\" value=\"{$car["id"]}\" />
                    <div class=\"row\"> 
                    <div class=\"col\"> 
   <button type=\"submit\" class=\"btn btn-danger\">      
            Delete</button>
            </div>
                  </form>
                  <div class=\"col\"> 
            <a  class=\"btn btn-info\" href=\"carEdit.php?id={$car["id"]}\">Update</a></td>
            </div>
            </div> ";
                                            echo "</tr>";
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
        </div>
    </div>


<?php } else {
    header("location: /views/login.php");
} ?>