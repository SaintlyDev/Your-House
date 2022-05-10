<?php
require_once("../Classes/DB/DbCon.Class.php");
require_once("../Classes/Entity/Person.Class.php");
require_once("../Classes/Room/Room.class.php");
$susAmount = 3;
$search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($search)) {

    $query = "SELECT r.* FROM people p INNER join `personinroom` pr ON pr.Pid = p.ID INNER JOIN `rooms` r ON pr.Rid = r.ID WHERE p.Name LIKE '%" . $search . "%' ORDER BY r.ID;";
    // same but simple "SELECT room.* FROM room, person, person_room WHERE person.ID=person_room.Pid AND room.ID=person_room.Rid AND person.Name LIKE '%Mom%';"
    // good and faster "SELECT r.* FROM person p INNER join `person_room` pr ON pr.Pid = p.ID INNER JOIN `room` r ON pr.Rid = r.ID WHERE p.Name LIKE '%Mom%';"
    $result = DbCon::$PDO->prepare($query);
    $result->execute();
    while ($room = $result->fetch()) {
        $allRooms[] = new Room($room["ID"], $room["Name"]);
    }
    if (isset($allRooms)) {
        foreach ($allRooms as $roomers) {
            echo $roomers->get_name();
            echo ": ";
            // show how many people are in this room
            switch (count($peopleInside = $roomers->get_personInRoom($roomers->get_id()))) {
                case false:
                    echo "";
                    break;
                case 0 || false:
                    echo "no one is inside.";
                    break;
                case 1:
                    echo count($peopleInside) . " Person. In this Room: ";
                    break;
                default:
                    echo count($peopleInside) . " People. In this Room: ";
                    break;
            }
            $counter = 0;
            // show the person/people names
            foreach ($roomers->get_personInRoom($roomers->get_id()) as $person) {
                if ($counter > 0) {
                    echo ", ";
                }
                echo $person->get_name();
                $counter += 1;
            }
            echo "</br>";
            //start rumor is they are sus
            if (count($roomers->get_personInRoom($roomers->get_id())) >= $susAmount)
                echo "<pre>   i wonder what they are doing?</pre>";
            // if fabi is in this room HS
            elseif (in_array(Person::get_Person(7), $roomers->get_personInRoom($roomers->get_id())))
                echo "<pre>   Hs Fabi is here huh?</pre>";
            // if this room is not yours but you are inside then: WTF?!
            elseif ($roomers->get_id() != (Room::get_Room(3))->get_id() && in_array(Person::get_Person(4), $roomers->get_personInRoom($roomers->get_id())))
                echo "<pre>   What are you doing here, this is not your room?!</pre>";
            else
                echo "<pre>   Nothing to see here.</pre>";
        }
    } else
        echo "No one was Found";
} else {
    foreach (Room::get_Rooms() as $roomers) {
        echo $roomers->get_name();
        echo ": ";
        // show how many people are in this room
        switch (count($roomers->get_personInRoom($roomers->get_id()))) {
            case false:
                echo "";
                break;
            case 0 || false:
                echo "no one is inside.";
                break;
            case 1:
                echo count($roomers->get_personInRoom($roomers->get_id())) . " Person. In this Room: ";
                break;
            default:
                echo count($roomers->get_personInRoom($roomers->get_id())) . " People. In this Room: ";
                break;
        }
        $counter = 0;
        // show the person/people names
        foreach ($roomers->get_personInRoom($roomers->get_id()) as $person) {
            if ($counter < 1) {
                echo $person->get_name();
                $counter += 1;
            } else {
                echo ", " . $person->get_name();
            }
        }
        echo "</br>";
        //start rumor is they are sus
        if (count($roomers->get_personInRoom($roomers->get_id())) >= $susAmount)
            echo "<pre>   i wonder what they are doing?</pre>";
        // if fabi is in this room HS
        elseif (in_array(Person::get_Person(7), $roomers->get_personInRoom($roomers->get_id())))
            echo "<pre>   Hs Fabi is here huh?</pre>";
        // if this room is not yours but you are inside then: WTF?!
        elseif ($roomers->get_id() != (Room::get_Room(3))->get_id() && in_array(Person::get_Person(4), $roomers->get_personInRoom($roomers->get_id())))
            echo "<pre>   What are you doing here, this is not your room?!</pre>";
        else
            echo "<pre>   Nothing to see here.</pre>";
    }
}
