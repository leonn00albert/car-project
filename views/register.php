<?php
session_start();
include "header.php";
// Check if an error message is set in the session
$errorMessage = isset($_SESSION["error"]) ? $_SESSION["error"] : "";
// Clear the error message from the session to avoid displaying it again on subsequent page loads

?>

<body>
    <div class="container text-center">
        <?php if (isset($errorMessage)) : ?>

            <div class="error-message">
                <?php include "components/alert.php";
                unset($_SESSION["error"]);
                ?>
            </div>
        <?php endif; ?>

        <?php include "nav.php"; ?>
        <div class="login-container">
            <div class="card">

                <h2>Register</h2>
                <form action=" /app/Controller.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="type" value="users">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="user" placeholder="Enter your name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter a password">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>