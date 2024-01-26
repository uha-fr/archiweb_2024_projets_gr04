<?php
require_once 'Core/Database.php';

class User {
    public static function validate($username, $password) {

        $pdo = Database::connect();
        $sql = "SELECT * FROM users WHERE username = :username";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user['password'] === $password) {
            return true;
            
            // var_dump($username, $password); // Vérifiez les données avant la requête

        }

        return false;
    }
    public function create($username, $password) {
        $pdo = Database::connect();
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        Database::disconnect();
    }
} 
