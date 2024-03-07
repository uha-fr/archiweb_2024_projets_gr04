<?php

namespace App\Models;

class RelationNutritionnisteModel extends Model {

    protected $id;
    protected $idNutritionniste;
    protected $idClient;

    public function __construct() {
        $this->table = 'relation_nutritionniste';
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of idNutritionniste
     */ 
    public function getIdNutritionniste()
    {
        return $this->idNutritionniste;
    }

    /**
     * Set the value of idNutritionniste
     *
     * @return  self
     */ 
    public function setIdNutritionniste($idNutritionniste)
    {
        $this->idNutritionniste = $idNutritionniste;

        return $this;
    }

    /**
     * Get the value of idClient
     */ 
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Set the value of idClient
     *
     * @return  self
     */ 
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }
}