<?php

require_once ('Models/Database.php');
require_once('Models/UserData.php');

class UsersDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function addUser($userID, $password, $firstName, $surname, $email) {
        $sqlQuery = "INSERT INTO users (`userID`, `password`, `firstName`, `surname`, `email`, `latitude`, `longitude`) VALUES ('$userID', '$password', '$firstName','$surname', '$email', '0', '0');";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function updateLocation($userID, $lat, $lon) {
        $sqlQuery = "UPDATE users SET `latitude` = '$lat', `longitude` = '$lon' WHERE (`userID` = '$userID')";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function fetchAllUsers() {
        $sqlQuery = 'SELECT * FROM users';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row, 2);
        }
        return $dataSet;
    }

    public function fetchAllUserIDs() {
        $sqlQuery = 'SELECT userID FROM users';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row, 2);
        }
        return $dataSet;
    }

    public function fetchAllUsersByUserID($search) {
        $sqlQuery = "SELECT * FROM users WHERE userID='$search'";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row, 2);
        }
        return $dataSet;
    }

    public function fetchAllUsersLogin($userID) {
        $sqlQuery = "SELECT userID, password FROM users WHERE userID='$userID'";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row, 1);
        }
        return $dataSet;
    }

    public function fetchAllUsersUserID($userID) {
        $sqlQuery = "SELECT userID FROM users WHERE userID='$userID'";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row, 0);
        }
        return $dataSet;
    }
}


