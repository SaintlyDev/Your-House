<?php

class Room
{
    private int $ID;
    private string $Name;
    /**
     * @var Person[] $PersonInRoom
     */
    private array $PersonInRoom = [];
    private int $MaxPeople = 20;

    public function __construct(int $id, string $name)
    {
        $this->ID = $id;
        $this->Name = $name;
    }
    function get_id(): int
    {
        return $this->ID;
    }

    function get_name(): string
    {
        return $this->Name;
    }

    public static function get_Room(int $id)
    {
        $query = "SELECT * FROM rooms WHERE ID=:id";
        $getRoomQuery = DbCon::$PDO->prepare($query);
        $getRoomQuery->execute([
            "id" => $id
        ]);
        $result = $getRoomQuery->fetchAll(PDO::FETCH_ASSOC);
        $oneRoom = 0;
        foreach ($result as $room) {
            $oneRoom = new Room($room["ID"], $room["Name"]);
        }
        return $oneRoom;
    }

    public static function get_Rooms() 
    {
        $query = "SELECT * FROM rooms ORDER BY ID";
        $getRoomQuery = DbCon::$PDO->prepare($query);
        $getRoomQuery->execute();
        $result = $getRoomQuery->fetchAll(PDO::FETCH_ASSOC);
        $allRooms = [];
        foreach ($result as $room) {
            $allRooms[] = new Room($room["ID"], $room["Name"]);
        }
        return $allRooms;
    }

    function add_personInRoom(int $Pid)
    {
        if (count($this->PersonInRoom) < $this->MaxPeople)
            $query = "INSERT INTO personinroom (Pid, Rid) VALUES (:Pid, :Rid) ON DUPLICATE KEY UPDATE Rid=:Rid";
        $addPersonRoomQuery = DbCon::$PDO->prepare($query);
        $addPersonRoomQuery->execute([
            "Pid" => $Pid,
            "Rid" => $this->ID
        ]);
    }

    function remove_personInRoom(int $personID)
    {
        if (count($this->PersonInRoom) < $this->MaxPeople)
            $query = "DELETE * FROM personinroom WHERE Pid=:id";
        $removePersonRoomQuery = DbCon::$PDO->prepare($query);
        $removePersonRoomQuery->execute([
            "id" => $personID
        ]);
    }

    function get_personInRoom(int $roomID): array
    {
        try {
            $query = "SELECT * FROM personinroom WHERE Rid=:id ORDER BY Pid";
        $getPersonRoomQuery = DbCon::$PDO->prepare($query);
        $getPersonRoomQuery->execute([
            "id" => $roomID
        ]);
        $result = $getPersonRoomQuery->fetchAll(PDO::FETCH_ASSOC);
        $allPeople = [];
        foreach ($result as $person) {
            $allPeople[] = Person::get_Person($person["Pid"]);
        }
        return $allPeople;
        } catch (\Throwable $th) {
            return 0;
        }
        
    }
}
