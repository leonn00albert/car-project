<?php

define(
    "USERS_DB",
    __DIR__ . "/" . "USERS_DB.json"
);

function readFromUsersJSON(): array
{
    $users = [];
    if (file_exists(USERS_DB)) {
        $json = file_get_contents(USERS_DB);
        $users = json_decode($json, true);
    }
    return $users;
}

function addDataToUsersJSON(string $id, string $user, $email, $password, $type): void //change to right  type later
{
    /// make sure to add unique  email  if not throw error
    $users = json_decode(file_get_contents(USERS_DB), true);
    $users[] = ["id" => $id, "user" => $user, "email" => $email, "password" => $password, "type" => $type];
    if (!file_put_contents(USERS_DB, json_encode($users))) {
        echo "Cannot write to the file!";
    }
}

function clearAndWriteUsersJSON(): void
{
    if (is_writable(USERS_DB)) {
        if (!file_put_contents(USERS_DB, json_encode([]))) {
            echo "Cannot write to the file!";
        }
    }
}

function updateUsersJSON(array $Users): void
{
    if (is_writable(USERS_DB)) {
        if (!file_put_contents(USERS_DB, json_encode($Users))) {
            echo "Cannot write to the file!";
        }
    }
}
