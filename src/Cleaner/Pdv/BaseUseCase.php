<?php

namespace App\Cleaner\Pdv;

abstract class BaseUseCase {

    public function __construct(PdvFactory $factory)
    {
        $this->factory = $factory;
    }

}