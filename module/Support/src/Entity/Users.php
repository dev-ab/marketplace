<?php

namespace Support\Entity;

class Users {

    protected $id;
    protected $fullname;
    protected $email;

    public function exchangeArray($data) {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->fullname = isset($data['fullname']) ? $data['fullname'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
