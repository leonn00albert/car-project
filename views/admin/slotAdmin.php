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
                                    <form method="POST" action="/app/Controller.php" style="width: 30%; margin: 0 auto;">
                                    <h5>Create Slot</h5>

                                        <input type="hidden" name="action" value="create" />
                                        <input type="hidden" name="type" value="slot" />
                                        <div class="mb-3">
                                            <input type="text" name="name" placeholder="time" class="form-control" id="exampleCheck1">
                                       
                                        </div>
                                 

                                        <input class="btn btn-primary" type="submit" value="submit" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card m-3 card-shadow">
                                <div class="card-body">
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
                    <div class=\"m-2\"> 
   <button type=\"submit\" class=\"btn btn-danger\">      
            Delete</button>
                  </form>
                  </div>
                ";
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