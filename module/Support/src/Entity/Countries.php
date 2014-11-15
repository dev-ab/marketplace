<?php

namespace Support\Entity;

class Countries {

    protected $id;
    protected $countryName;
    protected $userid;
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

    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    public function getUser_id() {
        return $this->userid;
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
