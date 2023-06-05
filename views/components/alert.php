<style>
    /* The alert message box */
    .alert {
        padding: 20px;
        width: 40%;
        background-color: #f44336;
        /* Red */
        color: white;
        margin-bottom: 15px;
        margin: 0 auto;
        background: linear-gradient(319deg, rgba(238, 70, 70, 0.86) 9%, rgba(221, 156, 156, 0.43) 100%);
        border-radius: 10px;
        box-shadow: 10px 10px 48px 0px rgba(77, 77, 77, 0.75);
        -webkit-box-shadow: 10px 10px 48px 0px rgba(77, 77, 77, 0.75);
        -moz-box-shadow: 10px 10px 48px 0px rgba(77, 77, 77, 0.75);
    }

    /* The close button */
    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    /* When moving the mouse over the close button */
    .closebtn:hover {
        color: black;
    }
</style>
<?php

if (isset($_SESSION["error"])) {
?>
    <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <?php echo $_SESSION["error"]; ?>
    </div>

<?php

}    ?>

<style>
    .alert {
        opacity: 1;
        transition: opacity 0.6s;
        /* 600ms to fade out */
    }
</style>

<script>
    // Get all elements with class="closebtn"
    var close = document.getElementsByClassName("closebtn");
    var i;

    // Loop through all close buttons
    for (i = 0; i < close.length; i++) {
        // When someone clicks on a close button
        close[i].onclick = function() {

            // Get the parent of <span class="closebtn"> (<div class="alert">)
            var div = this.parentElement;

            // Set the opacity of div to 0 (transparent)
            div.style.opacity = "0";

            // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
            setTimeout(function() {
                div.style.display = "none";
            }, 600);
        }
    }
</script>