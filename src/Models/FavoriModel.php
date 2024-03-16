<?php

namespace App\Models;

class FavoriModel extends Model {
    protected $id;
    protected $idUtilisateur;
    protected $type;
    protected $idFavori;

    public function __construct() {
        $this->table = 'favori';
    }
    
    /**
     * Get the value of idFavori
     */ 
    public function getIdFavori()
    {
        return $this->idFavori;
    }

    /**
     * Set the value of idFavori
     *
     * @return  self
     */ 
    public function setIdFavori($idFavori)
    {
        $this->idFavori = $idFavori;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of idUtilisateur
     */ 
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set the value of idUtilisateur
     *
     * @return  self
     */ 
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;

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