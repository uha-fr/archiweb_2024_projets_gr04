<?php

namespace App\Models;

class NotificationModel extends Model {

    protected $id;
    protected $type;
    protected $idUserOrigine;
    protected $idUserDest;
    protected $date;

    public function __construct() {
        $this->table = 'notification';
    }

    public function findUserOrigineNameByUserDest($idUserDest) {
        $query = 'SELECT notification.id AS idNotification, idUserOrigine, date, nom_utilisateur
                    FROM notification
                    LEFT JOIN utilisateurs ON notification.idUserOrigine = utilisateurs.id
                    WHERE idUserDest = \'' . $idUserDest .'\'
                    AND type = "demande-nutritionniste"
                    ORDER BY date';
        return $this->executeQuery($query)->fetchAll();
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
     * Get the value of idUserOrigine
     */ 
    public function getIdUserOrigine()
    {
        return $this->idUserOrigine;
    }

    /**
     * Set the value of idUserOrigine
     *
     * @return  self
     */ 
    public function setIdUserOrigine($idUserOrigine)
    {
        $this->idUserOrigine = $idUserOrigine;

        return $this;
    }

    /**
     * Get the value of idUserDest
     */ 
    public function getIdUserDest()
    {
        return $this->idUserDest;
    }

    /**
     * Set the value of idUserDest
     *
     * @return  self
     */ 
    public function setIdUserDest($idUserDest)
    {
        $this->idUserDest = $idUserDest;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate()
    {
        $this->date = date('Y-m-d H:i:s');

        return $this;
    }
}