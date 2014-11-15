<?php

namespace Support\Entity;

class Users {

    protected $id;
    protected $email;
    protected $password;
    protected $salt;
    protected $fullName;
    protected $phone;
    protected $country;
    protected $time;
    protected $date;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $pass = $this->preparePassword($password);
        $this->setSalt($pass['salt']);
        $this->password = $pass['password'];
        return $this;
    }

    protected function preparePassword($password) {
        $salt = '';
        for ($i = 0; $i < 50; $i++) {
            $salt .= chr(rand(33, 126));
        }
        $newPassword = md5('staticSalt' . $password . $salt);
        return array('password' => $newPassword, 'salt' => $salt);
    }

    public function getPassword() {
        return $this->password;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
        return $this;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    public function getCountry() {
        return $this->country;
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
