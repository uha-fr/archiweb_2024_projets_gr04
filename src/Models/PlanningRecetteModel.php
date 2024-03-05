<?php

namespace App\Models;

class PlanningRecetteModel extends Model {

    protected $id;
    protected $idRecette;
    protected $date;

    public function __construct() {
        $this->table = 'planning_recette';
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
     * Get the value of idRecette
     */ 
    public function getIdRecette()
    {
        return $this->idRecette;
    }

    /**
     * Set the value of idRecette
     *
     * @return  self
     */ 
    public function setIdRecette($idRecette)
    {
        $this->idRecette = $idRecette;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}