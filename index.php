<?php
// tis a test
error_reporting(E_ALL);

require_once("Classes/DB/DbCon.Class.php");
require_once("Classes/Entity/Person.Class.php");
require_once("Classes/Room/Room.class.php");

$yourMom = Person::get_Person(1);
$yourSister = Person::get_Person(2);
$yourDad = Person::get_Person(3);
$you = Person::get_Person(4);
$friend0 = Person::get_Person(5);
$yourBoss = Person::get_Person(6);
$fabi = Person::get_Person(7);

$zimmerYourMom = Room::get_Room(1);

$zimmerYourSister = Room::get_Room(2);

$zimmerYou = Room::get_Room(3);

if (isset($_POST["personMove"]) && isset($_POST["roomTarget"])) {
    $personMove = $_POST["personMove"];
    $roomTarget = $_POST["roomTarget"];
    $query = "UPDATE personinroom SET Rid=:Rid WHERE Pid=:Pid";
    $delPersonRoomQuery = DbCon::$PDO->prepare($query);
    $delPersonRoomQuery->execute([
        "Pid" => $personMove,
        "Rid" => $roomTarget
    ]);
}

$allRooms = Room::get_Rooms();
$allPeople = Person::get_People();

// Start of Page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="background-color: dimgray;">

    <label style="font-size: 20px;">Suchen: </label><input id="searchTxt" type="text" style="border-radius: 8px; font-size: 20px;" oninput="Search(this)"></input>
    </br>
    </br>
    <div id="ShowRooms" style="width: 100%;">

    </div>
    <form action="" method="POST">
        </br>
        <select id="personSelect" onchange="selectChange(this)" name="personMove" style="border-radius: 8px;">
            <?php
            foreach ($allPeople as $person) {
            ?>
                <option value="<?= $person->get_id() ?>"><?= $person->get_name() ?></option>
            <?php
            }
            ?>
        </select>
        <button id="btnToChange" style="border-radius: 8px;">Move Test to:</button>
        <select id="roomSelect" name="roomTarget" style="border-radius: 8px;">
            <?php
            foreach ($allRooms as $room) {
            ?>
                <option value="<?= $room->get_id() ?>"><?= $room->get_name() ?></option>
            <?php
            }
            ?>
        </select>
    </form>
</body>
<script src="indexFun.js"></script>
</html>
<?php
//End of Page
$yourMom->save_Person();
$yourSister->save_Person();
$yourDad->save_Person();
$you->save_Person();
$friend0->save_Person();
$yourBoss->save_Person();
$fabi->save_Person();

?>