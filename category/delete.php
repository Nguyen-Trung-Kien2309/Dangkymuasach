<?php
global $conn;
require_once __DIR__.('/../connect-db.php');

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $id = $_GET['id'];
    $sql = '
        DELETE FROM categories
        WHERE id = :id;
    ';
    try {
       $stmt= $conn->prepare($sql);
       $stmt->bindParam(':id',$id);

       $stmt->execute();


    } catch (PDOException $PDOException) {
        echo $PDOException->getMessage();
    }
    header('Location: ../categories.php');
}

require_once __DIR__.('/../close-php.php');
