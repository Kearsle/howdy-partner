<?php

require_once('Models/UsersDataSet.php');

$usersTableDataSet = new UsersDataSet();

$a = array();

// Create a array containing all userID's
foreach ($usersTableDataSet->fetchAllUsers() as $userTableData) {
    array_push($a, $userTableData->getUserID());
}

$q = $_REQUEST["q"];
$hint = "";

// find any userID's that begin with what the user has typed. If so add the userID's to the suggestion string.
if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// if there is no userID found, write no suggestion, else return the completed hint string
echo $hint === "" ? "no suggestion" : $hint;