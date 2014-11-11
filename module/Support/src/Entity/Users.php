<?php

namespace Support\Entity;

class Users {

    public function exchangeArray() {
        
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

