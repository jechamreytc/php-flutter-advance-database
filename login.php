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
    function getDataWithID($json)
    {
        include "connection.php";
        $json = json_decode($json, true);
        $sql = "SELECT * FROM tbl_users_advance_database WHERE user_id = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userID", $json["userID"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? json_encode($result) : 0;
    }

    function getDataAll()
    {
        include "connection.php";
        $sql = "SELECT * FROM tbl_users_advance_database";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? json_encode($result) : 0;
    }

    function updateData($json)
    {
        include "connection.php";
        $json = json_decode($json, true);
        $sql = "UPDATE tbl_users_advance_database SET user_username = :username, user_fname = :fname, user_lname = :lname WHERE user_id = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $json["username"]);
        $stmt->bindParam(":fname", $json["fname"]);
        $stmt->bindParam(":lname", $json["lname"]);
        $stmt->bindParam(":userID", $json["userID"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }

    function deleteData($json)
    {
        include "connection.php";
        $json = json_decode($json, true);
        $sql = "DELETE FROM tbl_users_advance_database WHERE user_id = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userID", $json["userID"]);
        $stmt->execute();
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
    case 'getDataAll':
        echo $login->getDataAll();
        break;
    case 'getDataWithID':
        echo $login->getDataWithID($json);
        break;
    case 'updateData':
        echo $login->updateData($json);
        break;
    case 'deleteData':
        echo $login->deleteData($json);
        break;
    default:
        break;
}
