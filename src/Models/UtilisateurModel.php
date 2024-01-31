<?php

namespace App\Models;

class UtilisateurModel extends Model {

    protected $id;
    protected $nomUtilisateur;
    protected $email;
    protected $mdp;
    protected $role;
     
    public function __construct() {
        $this->table = 'utilisateurs';
    }

    public function findOneByEmail(string $email) {
        return $this->executeQuery('SELECT * FROM ' . $this->table . 'WHERE email = ?', [$email])->fetch();
    }

    public function findOneByNameAndPassword(string $name, string $password) {
        return $this->executeQuery('SELECT * FROM ' . $this->table . 'WHERE nom_utilisateur = ? AND mdp = ?', [$name, $password])->fetch();
    }

    /**
     * Ajoute un nouvel utilisateur à la base de données.
     *
     * @param string $nomUtilisateur
     * @param string $mdp
     * @param string $email
     * @param string $role
     * @return bool Renvoie true si l'ajout a réussi, false sinon.
     */
    public function addUser(string $nomUtilisateur, string $mdp, string $email, string $role): bool
    {
        $query = 'INSERT INTO ' . $this->table . ' (nom_utilisateur, mdp, email, role) VALUES (?, ?, ?, ?)';
        $result = $this->executeQuery($query, [$nomUtilisateur, $mdp, $email, $role]);

        return $result !== false;
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
     * Get the value of pseudo
     */ 
    public function getNomUtilisateur()
    {
        return $this->nomUtilisateur;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */ 
    public function setNomUtilisateur($nomUtilisateur)
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}