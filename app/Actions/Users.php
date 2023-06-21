<?php

require_once __DIR__ . '/Action.php';

require_once __DIR__ . '/../Database/Users.php';

class Users extends Action
{
    public function create(): bool
    {
        //add form clean up here for all inputs
        // add validation for password to make sure  min 8 char and contain chars and int
        session_start();
        try {
            $cleanData = [
                "user" => trim(htmlspecialchars($_POST["user"])),
                "password" => trim(htmlspecialchars($_POST["password"])),
                "email" => trim(htmlspecialchars($_POST["email"])),
            ];

            $unqiue  = true;
            $users = readFromUsersTable();

            if (!$this->isEmail($cleanData["email"])) {
                throw new Exception("Invalid email address.");
                header("Location: /views/register.php");
                return false;
                exit;
            }

            if (!$this->validatePassword($cleanData["password"])) {
                throw new Exception("Invalid password. Please make sure it is at least 8 characters long and includes an uppercase letter, a lowercase letter, a digit, and a special character.");
                header("Location: /views/register.php");
                return false;
                exit;
            }

            foreach ($users as $existingUser) {
                if ($existingUser["email"] === $cleanData["email"]) {
                    throw new Exception("Email already taken");
                    $unqiue = false;
                    exit;
                }
            }
            if ($unqiue) {
                $id = uniqid();
                addDataToUsersTable(
                    $id,
                    $cleanData["user"],
                    $cleanData["email"],
                    password_hash($cleanData["password"], PASSWORD_DEFAULT),
                    "user"
                );
                header("Location: /");
                $_SESSION["auth"] = true;
                $_SESSION["userName"] = $cleanData["user"];
                $_SESSION["userEmail"] = $cleanData["email"];
                $_SESSION["userId"] = $id;
                $_SESSION["type"] = "user";
                return true;
            }
        } catch (Exception $e) {

            $_SESSION["error"] = $e->getMessage();
            header("Location: /views/register.php");
            return false;
        }
    }
    public function read(): array
    {
        return readFromUsersTable();
    }
    public function login()
    {

        // sanitize the input to filter tags or special characters
        $email = trim(htmlspecialchars($_POST["email"]));  // is depecrated use htmlspecialchars instead
        $password = trim(htmlspecialchars($_POST["password"]));
        $users = readFromUsersTable();
        $result = [];
        foreach ($users as $existingUser) {
            if ($existingUser["email"] === $email) {
                $result =  $existingUser;
            }
        }
        if ($result !== null && isset($result["password"]) && password_verify($password, $result["password"])) {
            if (password_verify($password, $result["password"])) {
                updateLastLogin($result["id"]);
                $_SESSION["auth"] = true;
                $_SESSION["userId"] = $result["id"];
                $_SESSION["userName"] = $result["user"];
                $_SESSION["userEmail"] = $result["email"];
                $_SESSION["type"] = $result["type"];
                if ($result["type"] == "admin") {
                    header("Location: /views/admin/booking.php");
                } else {
                    header("Location: /");
                }

                exit;
            }
        } else {

            $_SESSION["error"] = "Invalid username or password.";
            header("Location: /views/login.php");
        }
    }

    private function validatePassword($password)
    {
        // Minimum length of 8 characters
        if (strlen($password) < 8) {
            return false;
        }

        // Must contain at least one uppercase letter, one lowercase letter, one digit, and one special character
        if (
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/[0-9]/', $password) ||
            !preg_match('/[^A-Za-z0-9]/', $password)
        ) {
            return false;
        }

        return true;
    }

    private function isEmail($string)
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL) !== false;
    }
}


$Users = new Users();
