<?php
session_start();
require_once "../../app/Controller.php";

if (
    (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
    (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
) {

    $car = $controller->getCar($_GET["id"]);
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
           
                        <h2>Cars</h2>
                            <h5>Update Cars</h5>
                            <form action="/app/Controller.php" method="POST">
                        <input type="hidden" name="action" value="update" />
                        <input type="hidden" name="type" value="cars" />
                        <input type="hidden" name="id" value="<?= $car["id"] ?>" />
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input onchange="showNamePreview()" type="text" id="name-input" name="name" class="form-control" value="<?= $car["name"] ?>">
                        </div>
                        <div class="mb-3 ">
                            <textarea onchange="showDescPreview()" id="desc-input" name="description" class="form-control" value=""><?= $car["description"] ?>
                        </textarea>
                        </div>
                        <div class="mb-3 ">
                            <input name="image" type="url" id="image-input" class="form-control" onchange="showImagePreview()" value="<?= $car["image"] ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        </div>
                    </div>
                    </div>
                    <div class="col">
                        <div class="card m-3 card-shadow">  
                        <div class="card-body">
                        <img id="image-preview" src="<?= $car["image"] ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title" id="name-preview"><?= $car["name"] ?> </h5>
                            <p class="card-text" id="desc-preview"><?= $car["description"] ?></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            function showImagePreview() {
                var imageInput = document.getElementById("image-input");
                var imagePreview = document.getElementById("image-preview");

                imagePreview.src = imageInput.value;
            }

            function showNamePreview() {
                var Input = document.getElementById("name-input");
                var Preview = document.getElementById("name-preview");

                Preview.textContent = Input.value;
            }

            function showDescPreview() {
                var Input = document.getElementById("desc-input");
                var Preview = document.getElementById("desc-preview");

                Preview.textContent = Input.value;
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <?php include "footer.php";?>

<?php } else {
    header("location: /views/login.php");
} ?>