<?php

require_once ('Models/Database.php');
require_once('Models/FriendData.php');

class FriendDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function requestFriend($sender, $recipient) {
        $sqlQuery = "INSERT INTO friends (`sender`, `recipient`, `status`) VALUES ('$sender', '$recipient', '0');";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function acceptFriendRequest($sender, $recipient) {
        $sqlQuery = "UPDATE friends SET `status` = '1' WHERE (`sender` = '$sender') AND (`recipient` = '$recipient');";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function declineFriendRequest($sender, $recipient) {
        $sqlQuery = "DELETE FROM friends WHERE (`sender` = '$sender') AND (`recipient` = '$recipient');";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function removeFriend($me, $friend) {
        $sqlQuery = "DELETE FROM friends WHERE ((`sender` = '$me') AND (`recipient` = '$friend')) OR ((`recipient` = '$me') AND (`sender` = '$friend'));";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function fetchAllFriends($userID) {
        $sqlQuery = "SELECT * FROM friends WHERE (sender='$userID' OR recipient='$userID') AND status=1";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new FriendData($row);
        }
        return $dataSet;
    }

    public function fetchAllFriendRequests($userID) {
        $sqlQuery = "SELECT * FROM friends WHERE recipient='$userID' AND status=0";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new FriendData($row);
        }
        return $dataSet;
    }
}


