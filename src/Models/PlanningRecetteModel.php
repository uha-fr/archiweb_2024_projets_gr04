<?php

namespace App\Models;

use PDO;

class PlanningRecetteModel extends Model {

    protected $id;
    protected $idPlanning;
    protected $idRecette;
    protected $dateDebut;
    protected $dateFin;

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

    public function findByDay($idPlanning, string $date) {
        
        $query = 'SELECT idRecette
            FROM planningrecette
            WHERE idPlanning = \'' . $idPlanning . '\'
            AND \'' . $date . '\' BETWEEN dateDebut AND dateFin;';

        return $this->executeQuery($query)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findByMonth($idPlanning, string $date) {
        $query = 'SELECT idRecette
            FROM planningrecette
            WHERE idPlanning = \'' . $idPlanning . '\'
            AND MONTH(dateDebut) = ' . $date;

        return $this->executeQuery($query)->fetchAll(PDO::FETCH_COLUMN);
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

    /**
     * Get the value of date
     */ 
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDateDebut($date)
    {
        $this->dateDebut = $date;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDateFin($date)
    {
        $this->dateFin = $date;

        return $this;
    }
}