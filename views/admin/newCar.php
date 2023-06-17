<?php

if (
    (isset($_SESSION["auth"]) && $_SESSION["auth"] == true)  &&
    (isset($_SESSION["type"]) && $_SESSION["type"] === "admin")
) {
?>


            <div class="row">
                <div class="col">
                    <form action="/app/Controller.php" method="POST">
                        <input type="hidden" name="action" value="create" />
                        <input type="hidden" name="type" value="cars" />
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input onchange="showNamePreview()" type="text" id="name-input" name="name" class="form-control" placeholder="name">
                        </div>
                        <div class="mb-3 ">
                            <textarea onchange="showDescPreview()" id="desc-input" name="description" class="form-control" placeholder="description">
                        </textarea>
                        </div>
                        <div class="mb-3 ">
                            <input name="image" type="url" id="image-input" class="form-control" onchange="showImagePreview()" placeholder="Enter Image URL">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img id="image-preview" src="https://www.pngkey.com/png/detail/233-2332677_image-500580-placeholder-transparent.png" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title" id="name-preview"> </h5>
                            <p class="card-text" id="desc-preview"></p>
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

<?php } else {
    header("location: /views/login.php");
} ?>