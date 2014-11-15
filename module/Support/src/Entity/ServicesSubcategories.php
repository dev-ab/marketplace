<?php

namespace Support\Entity;

class ServicesSubcategories {

    protected $id;
    protected $subcategoryName;
    protected $icon;
    protected $categoryId;
    protected $time;
    protected $date;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setSubcategoryName($subcategoryName) {
        $this->subcategoryName = $subcategoryName;
        return $this;
    }

    public function getSubcategoryName() {
        return $this->subcategoryName;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function geIcon() {
        return $this->icon;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getCategoryId() {
        return $this->categoryId;
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
