<?php

namespace Support\Entity;

class Countries {

    protected $id;
    protected $country_name;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->country_name = (isset($data['country_name'])) ? $data['country_name'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

?>
