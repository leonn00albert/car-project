<?php
require_once "../../app/Controller.php";
session_start();
if (isset($_SESSION["auth"]) && $_SESSION["auth"] == true) {
    include "../../views/header.php";
?>

<style>

.rate {
  float: left;
  height: 46px;
  padding: 0 10px;
}
.rate:not(:checked) > input {
  position:absolute;
  top:-9999px;
}
.rate:not(:checked) > label {
  float:right;
  width:1em;
  overflow:hidden;
  white-space:nowrap;
  cursor:pointer;
  font-size:30px;
  color:#ccc;
}
.rate:not(:checked) > label:before {
  content: '★ ';
}
.rate > input:checked ~ label {
  color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
  color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
  color: #c59b08;
}
.container { 
  margin: 4em auto;
}

.checked {
  color: #c59b08;
  width: 15px;
}

.container h2 {
  text-align:  center;
}

.form-group{
    display: flex;
align-items: center;
justify-content: center;
}
</style>
<body>
        <div class="page-container">
            <?php include "../../views/nav.php"; ?>
        <!-- Modal content -->
        <div class="modal-content">

            <p>
            <div class="container">
                <h2> Review your experience for <span id="carName"><?=$_GET["car"]?></span></h2>
                <form>
                <input type="hidden" name="action" value="create">
            <input type="hidden" name="type" value="reviews">
            <input type="hidden" name="product_id" >  
                <div class="form-group" style="width: 600px; margin: 0 auto;">
              
                    <div class="rate">
                        <input type="radio" id="star5" name="rating" value="5"  />
                        <label for="star5" title="text">5 stars</label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="text">4 stars</label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="text">3 stars</label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="text">2 stars</label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="text">1 star</label>
                    </div>

                </div>
                <button style="width: 600px; margin: 0 auto;" type="submit" class="btn btn-primary">Submit</button>

                </form>
            </div>
            </p>
        </div>
        </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="../../static/main.js"></script>
</body>

</html>

<?php
}
?>