<?php

global $conn;
require_once __DIR__ . ('/../connect-db.php');

$sql = '
            SELECT products.id as product_id,
                   products.name as product_name,
                   products.manufacturer as product_manufacturer,products.price as product_price,products.img as product_img, categories.color as category_color, products.features as product_features,products.description as product_description FROM products inner join 
                categories on products.id_category = categories.id
            
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


