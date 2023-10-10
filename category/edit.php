<?php
global $conn;
require_once __DIR__.('/../connect-db.php');
function getByID($conn,$id)
{
    try {
        $sql = '
        SELECT * FROM categories 
        where id = :id;
    ';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

       return  $stmt->fetch();

    } catch (PDOException $PDOException) {
        echo  $PDOException->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    $data  = getByID($conn,$id);


}
if ($_SERVER['REQUEST_METHOD'] === "POST"){
    $name = $_POST['name'];
    $color = $_POST['color'];
    $id = $_POST['id'];
    $data =getByID($conn,$id);

    if (empty($data)){
        die("Không có bản ghi nào");
    }

    $sql = '
            UPDATE categories 
            SET name = :name,
            color = :color
            where id = :id
            '
    ;

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':color',$color);
        $stmt->bindParam(':id',$id);

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
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="mb-3 mt-3">
            <label for="name">Tên:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?= $data['name'] ?>">
        </div>
        <div class="mb-3">
            <label for="color">Color:</label>
            <input type="color" class="form-control" id="color" placeholder="Enter color" name="color" value="<?= $data['color'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
