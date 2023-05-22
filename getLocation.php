<?php

require_once('Models/UsersDataSet.php');

$usersTableDataSet = new UsersDataSet();
$userID = $_REQUEST["u"];

$userTableDataSet = $usersTableDataSet->fetchAllUsersByUserID($userID);
$userTableData = $userTableDataSet[0];

// Finds the location of a specific user.
$location = array('latitude' => $userTableData->getLatitude(), 'longitude' => $userTableData->getLongitude());

// returns the latitude and longitude of a specified user
echo json_encode($location);