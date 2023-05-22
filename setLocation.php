<?php

require_once('Models/UsersDataSet.php');

$userID = $_POST['userID'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];

$usersTableDataSet = new UsersDataSet();

$usersTableDataSet->updateLocation($userID, $lat, $lon);

