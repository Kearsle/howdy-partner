<?php

$view = new stdClass();
$view->pageTitle = 'Friend Requests';

require_once('Models/UsersDataSet.php');
require_once('Models/FriendDataSet.php');

$usersTableDataSet = new UsersDataSet();
$view->usersTableDataSet = $usersTableDataSet->fetchAllUsers();

require_once("controller.php");
require_once('Views/friendRequests.phtml');