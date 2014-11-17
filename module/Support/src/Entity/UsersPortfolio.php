<?php

namespace Support\Entity;

class UsersPortfolio {

    protected $id;
    protected $userId;
    protected $subject;
    protected $description;
    protected $type;
    protected $time;
    protected $date;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    public function geSubject() {
        return $this->subject;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function geDescription() {
        return $this->description;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setTime($time) {
        $this->time = $time;
        return $this;
    }

    public function getTime() {
        return $this->time;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

}
