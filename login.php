<?php

include "connection.php";
include "headers.php";

class Login
{
    function login($json)
    {
        // {"username": "admin", "password": "admin"}
        include "connection.php";
        $json = json_decode($json, true);
        $sql = "SELECT * FROM tbl_users_advance_database WHERE user_username = :username AND  BINARY user_password = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $json['username']);
        $stmt->bindParam(":password", $json['password']);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? json_encode($stmt->fetch(PDO::FETCH_ASSOC)) : 0;
    }
    function register($json)
    {
        include "connection.php";
        $json = json_decode($json, true);
        
        $sql = "INSERT INTO tbl_users_advance_database (user_username, user_password, user_fname, user_lname) 
                VALUES (:username, :password, :fname, :lname)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $json['username']);
        $stmt->bindParam(":password", $json['password']);
        $stmt->bindParam(":fname", $json['fname']);
        $stmt->bindParam(":lname", $json['lname']);
        
        $stmt->execute();
        
        // Return 1 if the insert was successful, otherwise 0
        return $stmt->rowCount() > 0 ? 1 : 0;
    }
    
}

$json = isset($_POST['json']) ? $_POST['json'] : "0";
$operation = isset($_POST['operation']) ? $_POST['operation'] : "0";
$login = new Login();

switch ($operation) {
    case 'login':
        echo $login->login($json);
        break;
    case 'register':
        echo $login->register($json);
        break;
    default:
        break;
}
