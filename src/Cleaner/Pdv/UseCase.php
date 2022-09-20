<?php

namespace App\Cleaner\Pdv;

class UseCase extends BaseUseCase {

    public function getAll() {
        return $this->factory->getAll();
    }

    public function get($id) {
        return $this->factory->get($id);
    }
    
    public function getBy($params) {
        return $this->factory->getBy($params);
    }

    public function create() {

    }

}