<?php

namespace App\Models;

class AlimentModel extends Model {

    protected $id;
    protected $nom;
    protected $kcal;

    public function __construct() {
        $this->table = 'aliment';
    }

    public function findAlimentsByRecetteId($id) {
        $query = $this->executeQuery('SELECT aliment.id, aliment.nom FROM recettealiment JOIN aliment ON recettealiment.id_aliment = aliment.id WHERE recettealiment.id_recette = \'' . $id . '\'');
        return $query->fetchAll();
    }

    public function countAllAliments() {
        return $this->executeQuery('SELECT count(aliment.id) AS nbAliment FROM ' . $this->table)->fetch();
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
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
     * Get the value of kcal
     */ 
    public function getKcal()
    {
        return $this->kcal;
    }

    /**
     * Set the value of kcal
     *
     * @return  self
     */ 
    public function setKcal($kcal)
    {
        $this->kcal = $kcal;

        return $this;
    }
}