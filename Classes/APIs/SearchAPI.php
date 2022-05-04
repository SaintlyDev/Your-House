<?php
require_once('../DB/DbCon.php');

$search = $_GET("suche");
$query = "SELECT ID FROM person WHERE Name LIKE '%" . $search . "%'";
$results = $conn->query($query);

while ($result = $results->fetch_object()) {
    $return1[] = $result;
}

foreach ($return1 as $key) {
    $query = "SELECT ID FROM person WHERE Name LIKE '%" . $search . "%'";
    $results = $conn->query($query);
    while ($result = $results->fetch_object()) {
        $return2[] = $result;
    }
}


echo json_encode($return2, JSON_PRETTY_PRINT);   // this gives back the result as objects
//echo json_encode($results->fetch_all(), JSON_PRETTY_PRINT);   // this will make it an array
