<?php

namespace Support\Entity;

class ServicesCategories {

    protected $id;
    protected $categoryName;
    protected $icon;
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

    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
        return $this;
    }

    public function getCategoryName() {
        return $this->categoryName;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function geIcon() {
        return $this->icon;
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
