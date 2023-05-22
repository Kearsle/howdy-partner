<?php

class UserData {
    
    protected $_userID;
    protected $_password;
    protected $_firstName;
    protected $_surname;
    protected $_email;
    protected $_latitude;
    protected $_longitude;
    
    public function __construct($dbRow, $passExtra) {
        $this->_userID = $dbRow['userID'];
        if ($passExtra == 1) {
            $this->assignPassword($dbRow);
        } else if ($passExtra == 2) {
            $this->assignPassword($dbRow);
            $this->assignExtra($dbRow);
        }
    }

    private function assignPassword($dbRow) {
        $this->_password = $dbRow['password'];
    }

    private function assignExtra($dbRow) {
        $this->_firstName = $dbRow['firstName'];
        $this->_surname = $dbRow['surname'];
        $this->_email = $dbRow['email'];
        $this->_latitude = $dbRow['latitude'];
        $this->_longitude = $dbRow['longitude'];
    }

    public function getUserID() {
        return $this->_userID;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getFirstName() {
        return $this->_firstName;
    }

    public function getSurname() {
        return $this->_surname;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getLatitude() {
        return $this->_latitude;
    }

    public function getLongitude() {
        return $this->_longitude;
    }
}


