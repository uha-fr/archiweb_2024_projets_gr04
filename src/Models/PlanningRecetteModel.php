<?php

namespace App\Models;

class PlanningRecetteModel extends Model {

    protected $id;
    protected $idPlanning;
    protected $idRecette;
    protected $date;

    public function __construct() {
        $this->table = 'planningrecette';
    }


    public function findPlanningRecetteNameByPlanningId($planningId) {
        $query = 'SELECT * 
                    FROM `planningrecette` 
                    JOIN recette on planningrecette.idRecette = recette.id
                    WHERE idPlanning = \'' . $planningId . '\'';
        return $this->executeQuery($query)->fetchAll();
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

    /**
     * Get the value of idPlanning
     */ 
    public function getIdPlanning()
    {
        return $this->idPlanning;
    }

    /**
     * Set the value of idPlanning
     *
     * @return  self
     */ 
    public function setIdPlanning($idPlanning)
    {
        $this->idPlanning = $idPlanning;

        return $this;
    }
}