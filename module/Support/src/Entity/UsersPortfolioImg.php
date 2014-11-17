<?php

namespace Support\Entity;

class UsersPortfolioImg {

    protected $id;
    protected $portfolioId;
    protected $fileName;
    protected $time;
    protected $date;

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setPortfolioId($portfolioId) {
        $this->portfolioId = $portfolioId;
        return $this;
    }

    public function getPortfolioId() {
        return $this->portfolioId;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
        return $this;
    }

    public function getFileName() {
        return $this->fileName;
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
