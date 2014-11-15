<?php

namespace Support\Entity;

class Notifications {

    protected $id;
    protected $notification;
    protected $userId;
    protected $type;
    protected $target;
    protected $time;
    protected $date;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setNotification($notification) {
        $this->notification = $notification;
        return $this;
    }

    public function getNotification() {
        return $this->notification;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setTarget($target) {
        $this->target = $target;
        return $this;
    }

    public function getTarget() {
        return $this->target;
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
