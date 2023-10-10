<?php
global $data;
require_once('./category/select.php');
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
    <a href="./category/add.php" class="btn btn-primary">Thêm mới</a>
    <div class="row mt-4">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Color</th>
                <th>Action</th>
            </tr>
            <tr>
                <?php foreach ($data
                as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['name'] ?></td>
                <td>
                    <button style="width: 25px; height: 25px;background: <?= $item['color'] ?>"></button>
                </td>
                <td>
                    <a href="#!" onclick="deleteCategory(<?= $item['id'] ?>)" class="btn btn-danger">Xóa</a>
                    <a href="category/edit.php?id=<?= $item['id'] ?>" class="btn btn-primary">Sửa</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tr>
        </table>
    </div>
</div>

</body>
<script>
    function deleteCategory (id) {
        if(confirm("Không CTRL Z được đâu !! Vẫn muốn xóa à cu?")) {
            window.location.href = './category/delete.php?id=' + id;
        }
    }
</script>
</html>