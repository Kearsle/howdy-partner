<?php
session_start();

// Login button Pressed
if (isset($_POST["loginbutton"])) {

    require_once('Models/UsersDataSet.php');

    // Collect username and password for checking with password_verify
    $usersDataSet = new UsersDataSet();
    $view->usersDataSet = $usersDataSet->fetchAllUsersLogin($_POST["userID"]);

    if (empty($view->usersDataSet) || !password_verify($_POST["password"], $view->usersDataSet[0]->getPassword())) {
        $_SESSION["error"] = "userID or Password is incorrect.";
    } else {
        $_SESSION["login"] = $_POST["userID"];
    }
}

// Search function for the users page.
if (isset($_POST["searchbutton"])) {

    require_once('Models/UsersDataSet.php');

    $_SESSION["search"] = $_POST["search"];

    $usersTableDataSet = new UsersDataSet();
    $view->usersTableDataSet = $usersTableDataSet->fetchAllUsersByUserID($_SESSION["search"]);
}

// Clearing the latest search on the users page
if (isset($_POST["clearsearchbutton"])) {
    unset($_SESSION["search"]);
}

// Add friend button on the users page. This is sending a friend request to the recipient
if (isset($_POST["addFriend"])) {
    $recipient = substr($_POST["addFriend"],4);
    $sender = $_SESSION["login"];

    $friendsDataSet = new FriendDataSet();
    $friendsDataSet->requestFriend($sender, $recipient);
}

// If the user is logged in, collection of friend requests can be made.
if (isset($_SESSION["login"])) {
    require_once('Models/FriendDataSet.php');

    $friendsTableDataSet = new FriendDataSet();
    $view->friendsTableDataSet = $friendsTableDataSet->fetchAllFriends($_SESSION['login']);

    $friendRequestTableDataSet = new FriendDataSet();
    $view->friendRequestTableDataSet = $friendRequestTableDataSet->fetchAllFriendRequests($_SESSION['login']);
}

// Accepting a friend request turns the status from 0 to 1 on the friends database
if (isset($_POST["acceptFriend"])) {
    $sender = substr($_POST["acceptFriend"], 7);
    $recipient = $_SESSION["login"];

    $friendsDataSet = new FriendDataSet();
    $friendsDataSet->acceptFriendRequest($sender, $recipient);
}

// Declining a friend request removes the row from the friends database.
if (isset($_POST["declineFriend"])) {
    $sender = substr($_POST["declineFriend"], 8);
    $recipient = $_SESSION["login"];

    $friendsDataSet = new FriendDataSet();
    $friendsDataSet->declineFriendRequest($sender, $recipient);
}

// This also removes the row from the friends database but it is able to locate who is the origional request sender and recipiant
if (isset($_POST["removeFriend"])) {
    $friend = substr($_POST["removeFriend"], 7);
    $me = $_SESSION["login"];

    $friendsDataSet = new FriendDataSet();
    $friendsDataSet->removeFriend($me, $friend);
}

// Registering a new user to the database.
if (isset($_POST["registerbutton"])) {

    require_once('Models/UsersDataSet.php');

    $usersDataSet = new UsersDataSet();
    $view->usersDataSet = $usersDataSet->fetchAllUsersUserID($_POST["userID"]);
    if (empty($view->usersDataSet)) {
        // Converting the inputs to lower case and hashing the password to ensure it is secure for storage in the database.
        $usersDataSet->addUser(strtolower($_POST["userID"]), password_hash($_POST["password"], PASSWORD_DEFAULT), strtolower($_POST["firstName"]), strtolower($_POST["surname"]), strtolower($_POST["email"]));
    } else {
        $_SESSION["registerError"] = "userID is already taken.";
    }
}

// Logs the user out of the system
if (isset($_POST["logoutbutton"]))
{
    unset($_SESSION["login"]);
    session_destroy();
}
