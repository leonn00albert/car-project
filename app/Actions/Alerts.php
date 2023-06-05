<?php

require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/../Database/Alerts.php';
class Alerts extends Action
{
    public function create(): bool

    //add form clean up here  for all inputs

    {

        try {
            addDataToAlerts(
                uniqid(),
                $cleanData["name"],
            );
            header("location: /");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function read(): array
    {
        $data =  readFromSlotsJSON();
        return $data;
    }

    public function delete(): bool
    {
        if (isset($_POST["id"])) {
            header("location: /slotAdmin.php");
            return deleteSlotById($_POST["id"]);
        }
        return false;
    }
}


$Alerts = new Alerts();
