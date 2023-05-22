<?php

require_once('Models/UsersDataSet.php');
require_once('Models/FriendDataSet.php');

$friends = array();
$usersTableDataSet = new UsersDataSet();
$friendsTableDataSet = new FriendDataSet();
// collect the logged in user's userID
$loggedInUser = $_REQUEST["u"];

// Check through all users to see who is a friend.
// When a friend is found, the stored information is packaged into a array
foreach ($usersTableDataSet->fetchAllUsers() as $userTableData) {
    if (strtolower($userTableData->getUserID()) != strtolower($loggedInUser)) {
        $isFriend = false;
        foreach ($friendsTableDataSet->fetchAllFriends($loggedInUser) as $friendsTableData) {
            if ((((strcmp($friendsTableData->getSender(), $userTableData->getUserID()) == 0) && (strcmp($friendsTableData->getRecipient(), $loggedInUser == 0))) && ($friendsTableData->getStatus() == 1)) || (((strcmp($friendsTableData->getRecipient(), $userTableData->getUserID()) == 0) && (strcmp($friendsTableData->getSender(), $loggedInUser == 0))) && ($friendsTableData->getStatus() == 1))) {
                $isFriend = true;
            }
        }
        if ($isFriend) {
            $friend = array('userID' => $userTableData->getUserID(), 'firstName' => $userTableData->getFirstName(), 'surname' => $userTableData->getSurname() , 'email' => $userTableData->getEmail(), 'latitude' => $userTableData->getLatitude(), 'longitude' => $userTableData->getLongitude());
            array_push($friends, $friend);
        }
    }
}

// The final array is encoded using json and returned.
echo json_encode($friends);