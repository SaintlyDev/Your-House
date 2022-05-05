<?php

class Person
{
    private int $ID;
    private string $Name;
    public function __construct(int $id, string $name)
    {
        $this->ID = $id;
        $this->Name = $name;
    }

    public static function get_Person($id) 
    {
        $query = "SELECT * FROM people WHERE ID=:id";
        $getPersonQuery = DbCon::$PDO->prepare($query);
        $getPersonQuery->execute([
            "id" => $id
        ]);
        $result = $getPersonQuery->fetchAll(PDO::FETCH_ASSOC);
        $onePerson = 0;
        foreach ($result as $person) {
            $onePerson = new Person($person["ID"], $person["Name"]);
        }
        return $onePerson;
    }

    public static function get_People() 
    {
        $query = "SELECT * FROM people ORDER BY ID";
        $getPersonQuery = DbCon::$PDO->prepare($query);
        $getPersonQuery->execute();
        $result = $getPersonQuery->fetchAll(PDO::FETCH_ASSOC);
        $allPeople = [];
        foreach ($result as $person) {
            $allPeople[] = new Person($person["ID"], $person["Name"]);
        }
        return $allPeople;
    }

    public function save_Person()
    {
        $query = "INSERT INTO people (ID, Name) VALUES (:id, :name) ON DUPLICATE KEY UPDATE Name=:name";
        $getPersonQuery = DbCon::$PDO->prepare($query);
        $getPersonQuery->execute([
            "id" => $this->ID,
            "name" => $this->Name
        ]);
    }

    function get_name()
    {
        return $this->Name;
    }

    function set_name(string $name)
    {
        $this->Name = $name;
    }

    function get_id()
    {
        return $this->ID;
    }

}
