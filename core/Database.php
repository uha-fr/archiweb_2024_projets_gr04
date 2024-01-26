<?php
class Database {
    private static $host = 'localhost';
    private static $dbName = 'manger';
    private static $username = 'projet_manger';
    private static $password = 'azerty';

    public static function connect() {
        try {
            $pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName, self::$username, self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function disconnect() {
        $pdo = null;
    }

    public static function addUser($username, $password) {
        $pdo = Database::connect();
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        Database::disconnect();
    }

    public static function deleteUser($username) {
        $pdo = Database::connect();
        $sql = "DELETE FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        Database::disconnect();
    }


    
}

