<?php

namespace Support\Entity;

class Countries {

    protected $id;
    protected $countryName;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setCountryName($countryName) {
        $this->countryName = $countryName;
        return $this;
    }

    public function getCountryName() {
        return $this->countryName;
    }

}
