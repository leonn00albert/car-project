<?php
session_start();
require_once "../../app/Controller.php";

if (
    (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
    (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
) {

    $car = $controller->getCar($_GET["id"]);
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>

    <body>
        <div class="container m-5">
            <div class="row">
                <div class="col">
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
                <div class="col">
                    <div class="card" style="width: 18rem;">
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
    </body>

    </html>

<?php } else {
    header("location: login.php");
} ?>