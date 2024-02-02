<?php

namespace App\Models;

class AlimentModel extends Model {

    protected $id;
    protected $nom;

    public function __construct() {
        $this->table = 'aliment';
    }

    public function findAlimentsByRecetteId($id) {
        $query = $this->executeQuery('SELECT aliment.id, aliment.nom FROM recette_aliment JOIN aliment ON recette_aliment.id_aliment = aliment.id WHERE recette_aliment.id_recette = ' . $id);
        return $query->fetchAll();
    }

    public function countAllAliments() {
        return $this->executeQuery('SELECT count(aliment.id) AS nbAliment FROM ' . $this->table)->fetch();
    }

    public function findByLimits(int $premierItem, int $nbItem) {
        $query = $this->executeQuery('SELECT * FROM ' . $this->table . ' ORDER BY nom LIMIT ' . $premierItem . ', ' . $nbItem);
        return $query->fetchAll();
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
}