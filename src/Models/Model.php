<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Model extends Database {
    protected $table;

    private $db;

    // SELECT * FROM table
    public function findAll():array {
        $query = $this->executeQuery('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    // SELECT * FROM table WHERE criteres
    public function findBy(array $criteres):array {
        $champs = [];
        $valeurs = [];

        foreach($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $listChamps = implode(' AND ', $champs);

        return $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE ' . $listChamps, $valeurs)->fetchAll();
    }

    public function find (string $id) {
        $query =  $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE id = \'' . $id . '\'');
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\\' . $this->table . 'Model');
        return $query->fetch();
    }

    public function countAll() {
        return $this->executeQuery('SELECT count(*) AS items FROM ' . $this->table)->fetch();
    }

    public function findByLimitsGeneral(int $premierItem, int $nbItem) {
        $query = $this->executeQuery('SELECT * FROM ' . $this->table . ' LIMIT ' . $premierItem . ', ' . $nbItem);
        return $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\\' . $this->table . 'Model');
    }

    public function executeQuery(string $sql, array $attributs = null){

        $this->db = Database::getInstance();

        if($attributs !== null) {
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        }else{
            return $this->db->query($sql);
        }
    }

    public function create(){
        $champs = [];
        $inter = [];
        $valeurs = [];

        foreach($this as $champ => $valeur) {
            if($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champ[] = $champ;
                $inter[] = "?";
                $valeur[] = $valeur;
            }
        }

        $listChamps = implode(', ', $champs);
        $listeInter = implode(', ', $inter);

        return $this->executeQuery('INSERT INTO ' . $this->table . ' (' . $listChamps . ')VALUES(' . $listeInter . ')', $valeurs);
    }


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

    public function delete(int $id)
    {
        return $this->executeQuery("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function hydrate($donnees) {
        foreach($donnees as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if(method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
        return $this;
    }

}