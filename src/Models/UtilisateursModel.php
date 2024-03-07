<?php

namespace App\Models;

class UtilisateursModel extends Model {

    protected $id;
    protected $nom_utilisateur;
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

    public function findByLimitesNutritionnistesDetails($premierItem, $itemsParPage, int $userId) {
        
        $query = 'SELECT
                    utilisateurs.id,
                    utilisateurs.nom_utilisateur,
                    COUNT(relation_nutritionniste.idClient) AS nbRelations,
                    IF(EXISTS (
                        SELECT 1
                        FROM notification
                        WHERE idUserOrigine = ? AND idUserDest = utilisateurs.id
                    ), true, false) AS notif
                    FROM
                        utilisateurs
                    LEFT JOIN
                        relation_nutritionniste ON utilisateurs.id = relation_nutritionniste.idNutritionniste
                    WHERE
                        utilisateurs.role = \'nutritionniste\'
                    GROUP BY
                        utilisateurs.id
                    LIMIT 
                        ' . $premierItem . ', ' . $itemsParPage;

        return $this->executeQuery($query, [$userId])->fetchAll();
    }

    /**
     * Ajoute un nouvel utilisateur à la base de données.
     *
     * @param string $nom_utilisateur
     * @param string $mdp
     * @param string $email
     * @param string $role
     * @return bool Renvoie true si l'ajout a réussi, false sinon.
     */
    public function addUser(string $nom_utilisateur, string $mdp, string $email, string $role): bool
    {
        $query = 'INSERT INTO ' . $this->table . ' (nom_utilisateur, mdp, email, role) VALUES (?, ?, ?, ?)';
        $result = $this->executeQuery($query, [$nom_utilisateur, $mdp, $email, $role]);

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
        return $this->nom_utilisateur;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */ 
    public function setNomUtilisateur($nomUtilisateur)
    {
        $this->nom_utilisateur = $nomUtilisateur;

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