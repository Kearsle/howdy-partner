<?php

class FriendData {

    protected $_sender;
    protected $_recipient;
    protected $_status;

    public function __construct($dbRow) {
        $this->_sender = $dbRow['sender'];
        $this->_recipient = $dbRow['recipient'];
        $this->_status = $dbRow['status'];
    }

    public function getSender() {
        return $this->_sender;
    }

    public function getRecipient() {
        return $this->_recipient;
    }

    public function getStatus() {
        return $this->_status;
    }
}


