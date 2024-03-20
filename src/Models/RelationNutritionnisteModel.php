<?php

namespace App\Models;

class RelationNutritionnisteModel extends Model {

    protected $id;
    protected $idNutritionniste;
    protected $idClient;
    protected $idPlanningPropose;
    protected $nutritionnisteAccesPlanning;

    public function __construct() {
        $this->table = 'relationnutritionniste';
    }

    public function findByLimitesUtilisateursRelationNutritionnisteDetails($premierItem, $nbItem, $idNutritionniste) {
        $query = 'SELECT utilisateurs.id, nom_utilisateur, nutritionnisteAccesPlanning AS acces
                    FROM relationnutritionniste
                    JOIN utilisateurs ON utilisateurs.id = relationnutritionniste.idClient
                    WHERE relationnutritionniste.idNutritionniste = ' . $idNutritionniste .
                    ' LIMIT ' . $premierItem . ', ' .$nbItem;
                    
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

    /**
     * Get the value of idPlanningPropose
     */ 
    public function getIdPlanningPropose()
    {
        return $this->idPlanningPropose;
    }

    /**
     * Set the value of idPlanningPropose
     *
     * @return  self
     */ 
    public function setIdPlanningPropose($idPlanningPropose)
    {
        $this->idPlanningPropose = $idPlanningPropose;

        return $this;
    }

    /**
     * Get the value of nutritionnisteAccesPlanning
     */ 
    public function getNutritionnisteAccesPlanning()
    {
        return $this->nutritionnisteAccesPlanning;
    }

    /**
     * Set the value of nutritionnisteAccesPlanning
     *
     * @return  self
     */ 
    public function setNutritionnisteAccesPlanning($nutritionnisteAccesPlanning)
    {
        $this->nutritionnisteAccesPlanning = $nutritionnisteAccesPlanning;

        return $this;
    }
}