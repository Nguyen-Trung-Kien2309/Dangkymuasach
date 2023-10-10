<?php
global $conn;
require_once __DIR__.('/../connect-db.php');
if ($_SERVER['REQUEST_METHOD'] === "POST"){
    $name = $_POST['name'];
    $color = $_POST['color'];

    $sql = '
            INSERT INTO categories (name,color)
            values (:name , :color)
            '
    ;

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':color',$color);

        $stmt->execute();

    } catch (PDOException $PDOException){
        echo $PDOException->getMessage();
    }
    header('Location:../categories.php');

}
require_once __DIR__.('/../close-php.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CRUD Danh mục</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
    <h2>Form Thêm Mới Danh mục</h2>
    <form action="add.php" method="post">
        <div class="mb-3 mt-3">
            <label for="name">Tên:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        <div class="mb-3">
            <label for="color">Color:</label>
            <input type="color" class="form-control" id="color" placeholder="Enter color" name="color">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
