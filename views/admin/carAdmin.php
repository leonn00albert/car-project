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
                                    <?php include "../../views/admin/alerts.php"; ?>
                                    <h2>Cars</h2>
                                    <h5>Create Car</h5>
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
                                            <th>

                                            </th>
                                        </tr>
                                        <?php
                                        $cars = $controller->Get("cars");
                                        foreach ($cars as $car) :
                                        ?>
                                            <tr>
                                                <td><img class="table-avatar" src=<?= $car["image"] ?> /></td>
                                                <td><?= $car["id"] ?></td>
                                                <td><?= $car["name"] ?></td>
                                                <td>
                                                    <form action="/app/Controller.php" method="POST">
                                                        <input type="hidden" name="type" value="cars" />
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="id" value="<?= $car["id"] ?>" />

                                                        <button type="submit" class="btn btn-danger">
                                                            Delete</button>




                                                    </form>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info" href="carEdit.php?id=<?= $car["id"] ?>">Update</a>

                                                </td>
                                            </tr>

                                        <?php endforeach; ?>

                                    </table>
                                </div>
                            </div>
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