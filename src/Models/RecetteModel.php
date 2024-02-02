<?php

namespace App\Models;

class RecetteModel extends Model {

    protected $id;
    protected $nom;
    protected $description;

    public function __construct() {
        $this->table = 'recette';
    }

    /**
     * Retourne les recettes qui correspondent à l'ensemble des aliments d'id $ids
     *
     * @param array $ids Les id des aliments
     * @return array
     */
    public function findByIdsAliments(array $ids):array {
        $sqlJoins = "";
        foreach ($ids as $index => $id) {
            $alias = "ra" . ($index + 1);  // Utilisation d'un alias unique pour chaque join
            $sqlJoins .= "JOIN recette_aliment $alias ON r.id = $alias.id_recette AND $alias.id_aliment = ? ";
        }
        $query =  $this->executeQuery('SELECT r.id, r.nom FROM ' . $this->table . ' r ' . $sqlJoins, $ids);
        return $query->fetchAll(); 
    }

    public function countAllRecettes() {
        return $this->executeQuery('SELECT count(recette.id) AS nbRecette FROM ' . $this->table)->fetch();
    }

    public function findByLimits(int $premierItem, int $nbItem) {
        $query = $this->executeQuery('SELECT * FROM ' . $this->table . ' ORDER BY nom LIMIT ' . $premierItem . ', ' . $nbItem);
        return $query->fetchAll();
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
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}