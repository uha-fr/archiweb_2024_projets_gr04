<?php

namespace App\Models;

use PDO;

class RecetteModel extends Model {

    protected $id;
    protected $nom;
    protected $description;
    protected $id_utilisateur;

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
            $sqlJoins .= "JOIN recettealiment $alias ON r.id = $alias.id_recette AND $alias.id_aliment = ? ";
        }
        $query =  $this->executeQuery('SELECT r.id, r.nom FROM ' . $this->table . ' r ' . $sqlJoins . ' WHERE id_utilisateur = -1 OR id_utilisateur = ' . $_SESSION['utilisateur']['id'], $ids);
        return $query->fetchAll(); 
    }

    public function countAllRecettes() {
        return $this->executeQuery('SELECT count(recette.id) AS nbRecette FROM ' . $this->table . ' WHERE id_utilisateur = -1 OR id_utilisateur = \'' . $_SESSION['utilisateur']['id'] . '\'')->fetch();
    }

    public function findByLimits(int $premierItem, int $nbItem) {
        $query = $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE id_utilisateur = -1 OR id_utilisateur = \'' . $_SESSION['utilisateur']['id'] . '\' ORDER BY nom LIMIT ' . $premierItem . ', ' . $nbItem);
        return $query->fetchAll();
    }

    /**
     * Ajoute une recette et ses aliments associés
     *
     * @param string $nom
     * @param string $desc
     * @param array $ingredients
     * @return void
     */

    public function supprimerRecetteById(string $idRecette) {
        $queryRecette = 'DELETE FROM ' . $this->table . ' WHERE id = ? AND id_utilisateur = ' . $_SESSION['utilisateur']['id'];
        $res = $this->executeQuery($queryRecette, [$idRecette]);
        $res = $res->rowCount();
        
        if($res > 0) { //Evite qu'un utilisateur supprimes les ingrédients de recette d'un autre utilisateur
            $queryAliments = 'DELETE FROM recettealiment WHERE id_recette = ?';
            $this->executeQuery($queryAliments, [$idRecette]);
        }
    }

    public function findByUser(string $idRecette) {
        $query = $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE id = \'' . $idRecette . '\' AND (id_utilisateur = -1 OR id_utilisateur = ' . $_SESSION['utilisateur']['id'] . ')');
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\\' . $this->table . 'Model');
        return $query->fetch();
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

    /**
     * Get the value of id_utilisateur
     */ 
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * Set the value of id_utilisateur
     *
     * @return  self
     */ 
    public function setIdUtilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }
}