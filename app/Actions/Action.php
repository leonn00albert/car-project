<?php
require_once __DIR__ . '/Interface.php';

class Action implements ActionInterface
{
    public function create(): bool
    {
        $query = [];

        print_r($query);
        return true;
    }

    public function update(): bool
    {
        $query = [];

        print_r($query);
        return true;
    }

    public function delete(): bool
    {
        if (!empty($_POST["id"])) {
            print true;
            return true;
        } else {
            throw new Exception("no id");
            return false;
        }
    }

    public function read(): array
    {
        $data = [];
        return $data;
    }
}
