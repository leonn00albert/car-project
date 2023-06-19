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
                        <h2>Reviews</h2>
            <table class="table">
                <tr>
                    <th>
                        Rating
                    </th>
                    <th>
                        userId
                    </th>
                    <th>
                        carId
                    </th>
             
                </tr>
                <?php
                $users = $controller->Get("reviews");
                foreach ($users as $user) :?>
                    <tr>
                        <td>
                        <?php if (isset($user["rating"])): ?>
                            <div class=" lead">
                                <div id="stars" class="starrr"></div>
                                <?php 
                                    for($i =0; $i <  $user["rating"]; $i++){
                                        echo "<span class=\"fa fa-star checked\"></span>";
                                    }
                                ?>  

                        </td>
    
                <?php endif; 

                echo <<<EOD
                         
                               <td>{$user["userId"]}</td>
                            <td>{$user["carId"]}</td>
           
                        EOD;


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


<?php } else {
    header("location: /views/login.php");
} ?>
        