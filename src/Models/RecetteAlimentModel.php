<?php

namespace App\Models;

class RecetteAlimentModel extends Model {

    protected $id_recette;
    protected $id_aliment;
    protected $quantite;

    public function __construct() {
        $this->table = 'recettealiment';
    }

    public function findDetailsAlimentByRecetteIdArray(array $recettesIds) {
        $champs = '(';
        foreach($recettesIds as $id) {
            $champs .= '?, ';
        }
        $champs = rtrim($champs, ', ') . ')';
        $query = 'SELECT * 
                    FROM recettealiment
                    JOIN aliment ON recettealiment.id_aliment = aliment.id
                    WHERE recettealiment.id_recette IN ' . $champs;
        return $this->executeQuery($query, $recettesIds)->fetchAll();
    }

    /**
     * Get the value of id_recette
     */ 
    public function getIdRecette()
    {
        return $this->id_recette;
    }

    /**
     * Set the value of id_recette
     *
     * @return  self
     */ 
    public function setIdRecette($id_recette)
    {
        $this->id_recette = $id_recette;

        return $this;
    }

    /**
     * Get the value of id_aliment
     */ 
    public function getIdAliment()
    {
        return $this->id_aliment;
    }

    /**
     * Set the value of id_aliment
     *
     * @return  self
     */ 
    public function setIdAliment($id_aliment)
    {
        $this->id_aliment = $id_aliment;

        return $this;
    }

    /**
     * Get the value of quantite
     */ 
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set the value of quantite
     *
     * @return  self
     */ 
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }
}