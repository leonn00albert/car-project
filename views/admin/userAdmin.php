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
                            <h2>Users</h2>
                            <table class="table">
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        email
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        type
                                    </th>
                                    <th>
                                        Created 
                                    </th>
                                    <th>
                                        Last Login
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                                <?php
                                $users = $controller->Get("users");
                                foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?=$user["id"]?></td>
                                        <td><?=$user["email"]?></td>
                                        <td><?=$user["user"]?></td>
                                        <td><?=$user["type"]?></td>
                                        <td><?=$user["created_at"]?></td>
                                        <td><?=$user["last_login"]?></td>
                                    </tr>
                                <?php endforeach;?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
<?php } else {
    header("location: /views/login.php");
} ?>