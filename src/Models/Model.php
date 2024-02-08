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

    public function find (string $id) {
        return $this->executeQuery('SELECT * FROM ' . $this->table . ' WHERE id = \'' . $id . '\'')->fetch();
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

    // public function update(){
    //     $champs = [];
    //     $valeurs = [];

    //     foreach($this as $champ => $valeur) {
    //         if($valeur !== null && $champ != 'db' && $champ != 'table') {
    //             $champ[] = "$champ = ?";
    //             $valeur[] = $valeur;
    //         }
    //     }
    //     $valeurs[] = $this->id;

    //     $listChamps = implode(', ', $champs);

    //     return $this->executeQuery('UPDATE  ' . $this->table . ' SET ' . $listChamps . ' WHERE id = ?', $valeurs);
    // }

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