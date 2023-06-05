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
                <h2>Login</h2>
                <form action="/auth/login" method="POST">
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="type" value="users">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="text" class="form-control" name="email" id="username" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

            </div>
        </div>
    </div>

</body>