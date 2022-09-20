<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractFactory {
    
    private $security;

    private $em;

    public function __construct(
        EntityManagerInterface $em,
        Security $security
    )
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function em() {
        return $this->em;
    }

    public function getAll() {
        return $this->repo()->findAll();
    }

    public function get($id) { 
        return $this->repo()->find($id);
    }

    public function getBy($params = []) {
        return $this->repo()->findBy($params);
    }

    public function getSearchBy($params = []) {
        return $this->repo()->searchBy($params);
    }

    public function getUser() {
        return $this->security->getUser();
    }
    
}