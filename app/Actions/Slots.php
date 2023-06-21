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
            session_start();
            $_SESSION["alert"]["type"] = "success";
            $_SESSION["alert"]["message"] = "Created slot";
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
        session_start(); 
        try {
            if (isset($_POST["id"])) {
            header("location: /views/admin/slotAdmin.php");
            session_start();    
            $_SESSION["alert"]["type"] = "success";
            $_SESSION["alert"]["message"] = "Deleted slot";
          
            return deleteSlotById($_POST["id"]);
        }
    }
        catch(Exception $e) {
            $_SESSION["alert"]["type"] = "error";
            $_SESSION["alert"]["message"] = "Something went wrong: " . $e->getMessage();
            return false;
        }
    }
}


$Slots = new Slots();
