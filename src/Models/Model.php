<?php

namespace App\Models;

use App\Core\Database;

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

    public function find (int $id) {
        return $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id)->fetch();
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
}