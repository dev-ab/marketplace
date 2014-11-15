<?php

namespace Support\Entity;

class Services {

    protected $id;
    protected $userId;
    protected $subject;
    protected $description;
    protected $category;
    protected $subcategory;
    protected $type;
    protected $price;
    protected $duration;
    protected $periodic;
    protected $requiredData;
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

    public function setCategory($category) {
        $this->category = $category;
        return $this;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setSubcategory($subcategory) {
        $this->subcategory = $subcategory;
        return $this;
    }

    public function getSubcategory() {
        return $this->subcategory;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function setPeriodic($periodic) {
        $this->periodic = $periodic;
        return $this;
    }

    public function getPeriodic() {
        return $this->periodic;
    }

    public function setRequiredData($requiredData) {
        $this->requiredData = $requiredData;
        return $this;
    }

    public function getRequiredData() {
        return $this->requiredData;
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
