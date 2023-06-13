<?php

require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/../Database/Slots.php';
class Day
{
    public function create($date, $selected = false): array
    {
        try {
            
            //add form clean up here  for all inputs
            $arr = [];
            $arr["date"] = $date;
            $arr["id"] = uniqid();
            $arr["slots"] = array_map(function ($slot) use ($selected) {
                if ($selected == $slot["name"]) {
                    return ["name" => $selected, "available" => false];
                }
                return ["name" => $slot["name"], "available" => true];
            }, readFromSlotsMYSQL());

            return $arr;
        } catch (Exception $e) {
            return [];
        }
    }
}


$Day = new Day();
