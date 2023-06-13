<?php

require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/../Database/Slots.php';
class Slots extends Action
{
    public function create(): bool

    //add form clean up here  for all inputs

    {
        $cleanData = [
            "name" => trim(htmlspecialchars($_POST["name"])),
        ];
        try {
            addDataToSlotsMYSQL(
                uniqid(),
                $cleanData["name"],
            );
            header("location: /views/admin/slotAdmin.php");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function read(): array
    {
        $data =  readFromSlotsMYSQL();
        return $data;
    }

    public function delete(): bool
    {
        if (isset($_POST["id"])) {
            header("location: /views/admin/slotAdmin.php");
            return deleteSlotById($_POST["id"]);
        }
        return false;
    }
}


$Slots = new Slots();
