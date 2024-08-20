<?php

include "connection.php";
include "headers.php";

class Operations
{
    function getOperations()
    {
        include "connection.php";
        $sql = "SELECT * FROM tbl_users_advance_database";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)) : 0;
    }
}

$json = isset($_POST['json']) ? $_POST['json'] : "0";
$operation = isset($_POST['operation']) ? $_POST['operation'] : "0";
$operations = new Operations();

switch ($operation) {
    case 'getOperations':
        echo $operations->getOperations();
        break;
    default:
        break;
}
