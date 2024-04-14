<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Model extends Database {
    protected $table;

    private $db;

    /**
     * Récupère tous les champs de la table courante
     *
     * @return array
     */
    public function findAll():array {
        $query = $this->executeQuery('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    /**
     * Récupère les champs de la table courante selon les critères
     *
     * @param array $criteres Tableau associatif des critères
     * @return array
     */
    public function findBy(array $criteres):array {
        $champs = [];
        $valeurs = [];

        foreach($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $listChamps = implode(' AND ', $champs);

        return $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE ' . $listChamps, $valeurs)->fetchAll(PDO::FETCH_CLASS, 'App\Models\\' . $this->table . 'Model');
    }

    /**
     * Récupère un champs selon son identifiant
     *
     * @param string $id Identifiant du champs
     * @return object
     */
    public function find (string $id) {
        $query =  $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE id = \'' . $id . '\'');
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\\' . $this->table . 'Model');
        return $query->fetch();
    }

    /**
     * Compte le nombre de champs dans la table courante
     *
     * @return object
     */
    public function countAll(array $criteres = []) {
        if(!empty($criteres)) {
            $champs = [];
            $valeurs = [];

            foreach($criteres as $champ => $valeur) {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }

            $listChamps = implode(' AND ', $champs);
            $query = $this->executeQuery('SELECT count(*) AS items FROM ' . $this->table . ' WHERE ' . $listChamps, $valeurs);
        }else{
            $query = $this->executeQuery('SELECT count(*) AS items FROM ' . $this->table);
        }
        return $query->fetch();
    }

    /**
     * Récupère les champs selon un intervalle
     *
     * @param integer $premierItem Début de l'intervalle
     * @param integer $nbItem Taille de l'intervalle
     * @param array $criteres Critères dans la clause WHERE
     * @return object
     */
    public function findByLimitsGeneral(int $premierItem, int $nbItem, array $criteres = [], $orderBy = "id") {
        if($premierItem < 0) $premierItem = 0;
        if(!empty($criteres)) {
            $champs = [];
            $valeurs = [];

            foreach($criteres as $champ => $valeur) {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }

            $listChamps = implode(' AND ', $champs);
            $query = $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE ' . $listChamps . ' ORDER BY ' . $orderBy . ' LIMIT ' . $premierItem . ', ' . $nbItem, $valeurs);
        }else{
            $query = $this->executeQuery('SELECT * FROM ' . $this->table  . ' ORDER BY ' . $orderBy . ' LIMIT ' . $premierItem . ', ' . $nbItem);
        }
        return $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\\' . $this->table . 'Model');
    }


    /**
     * Exécute une requête SQL sur la base de données.
     *
     * @param string $sql La requête SQL à exécuter.
     * @param array|null $attributs Les attributs à utiliser dans la requête préparée (optionnel).
     * @return object L'objet de requête préparée ou le résultat de la requête directe.
     */
    public function executeQuery(string $sql, array $attributs = null) {
        $this->db = Database::getInstance();
    
        try {
            if ($attributs !== null) {
                $query = $this->db->prepare($sql);
                $query->execute($attributs);
            } else {
                $query = $this->db->query($sql);
            }
        } catch (PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            throw new Exception("Erreur de base de données lors de l'exécution de la requête.");
        }
    
        return $query;
    }
    

    /**
     * Ajoute l'entitée courante en base de donnée
     *
     * @return void
     */
    public function create(){
        $champs = [];
        $inter = [];
        $valeurs = [];

        foreach($this as $champ => $valeur) {
            if($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        $listChamps = implode(', ', $champs);
        $listeInter = implode(', ', $inter);
        return $this->executeQuery('INSERT INTO ' . $this->table . ' (' . $listChamps . ')VALUES(' . $listeInter . ')', $valeurs);
    }


    /**
     * Modifie l'entité courante en base de données
     *
     * @return void
     */
    public function update() {
        $champs = [];
        $valeurs = [];

        foreach($this as $champ => $valeur) {
            if($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }

        $valeurs[] = $this->id; //ignore

        $listChamps = implode(', ', $champs);

        return $this->executeQuery('UPDATE  ' . $this->table . ' SET ' . $listChamps . ' WHERE id = ?', $valeurs);
    }

    /**
     * Supprime le champs d'id $id de la table courante de la base de données
     *
     * @param integer $id Identifiant du champs à supprimer
     * @return void
     */
    public function delete($id)
    {   
        return $this->executeQuery("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    // public function hydrate($donnees) {
    //     foreach($donnees as $key => $value) {
    //         $setter = 'set' . ucfirst($key);

    //         if(method_exists($this, $setter)) {
    //             $this->$setter($value);
    //         }
    //     }
    //     return $this;
    // }

}