<?php

global $conn;
require_once __DIR__ . ('/../connect-db.php');

    $sql = '
            SELECT * FROM categories
            ';

    try {
        $stmt = $conn->prepare($sql);


        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $data = $stmt->fetchAll();

    } catch (PDOException $PDOException) {
        echo $PDOException->getMessage();
    }
//require_once __DIR__ . ('/../close-php.php');


