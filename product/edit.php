<?php
global $conn;
require_once ('../category/select.php');
function getByID($conn,$id)
{
    try {
        $sql = '
            SELECT products.id as product_id, products.name as product_name, products.manufacturer as product_manufacturer,products.price as product_price,products.img as product_img, categories.color as category_color, products.features as product_features,products.description as product_description, categories.id as category_id FROM products inner join 
                categories on products.id_category = categories.id
       WHERE products.id = :id;
            
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
    $model  = getByID($conn,$id);
//    echo "<pre>";
//    print_r($data);
//    die;
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $model = getByID($conn,$id);
    if(empty($model)){
        die("không có bản ghi nào với id là : " . $id);
    }
    $targetFile = '../path/'.time().$_FILES['image']['full_path'];
    $path = time().$_FILES['image']['full_path'];
    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    $name = $_POST['name'];
    $price =$_POST['price'];
    $manufacturer = $_POST['manufacturer'];
    $category = $_POST['category'];
    $features = $_POST['features'];
    $description =$_POST['description'];
    $sql = '
            UPDATE  products
            SET name= :name , price = :price,manufacturer = :manufacturer,id_category =:id_category,features = :features, description =:description, img= :img
            where products.id = :id;
            '
    ;
    try {


        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':name',$name);

        $stmt->bindParam(':manufacturer',$manufacturer);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':id_category',$category);
        $stmt->bindParam(':features',$features);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':img',$path);
        $stmt->execute();
    } catch (PDOException $PDOException){
        echo $PDOException->getMessage();
    }
    header('Location: ../product.php');
}
require_once ('../close-php.php')


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>


<div class="container-xl">
    <h1>Form Sản Phẩm</h1>
    <h3 class="mt-4">Thêm/Sửa sản phẩm</h3>
    <form class="mt-2" method="POST" action="" enctype="multipart/form-data">
        <div class="row">
            <!-- Cột 1: Hãng sản xuất, giá, ảnh -->
            <div class="col-md-6">
                <div class="form-group mt-4">
                    <input type="hidden" name="id" value="<?= $model['product_id'] ?>">
                    <label for="name">Tên:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $model['product_name'] ?>"   placeholder="Tên sản phẩm...">
                </div>
                <div class="form-group mt-4">
                    <label for="manufacturer">Hãng sản xuất:</label>
                    <input type="text" class="form-control" id="manufacturer" name="manufacturer"  value="<?= $model['product_manufacturer'] ?>"
                           placeholder="Hãng....">
                </div>
                <div class="form-group mt-4">
                    <label for="price">Giá:</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Giá.." value="<?= $model['product_price'] ?>" >
                </div>
                <div class="form-group mt-4">
                    <label for="image">Ảnh:</label>
                    <input type="file" class="form-control" id="image" name="image" accept=".jpg,.png.jepg value="<?= $model['product_img'] ?>" >
                </div>
            </div>
            <!-- Cột 2: Loại, tính năng, mô tả -->
            <div class="col-md-6">
                <div class="form-group mt-4">
                    <label for="category">Thể loại:</label>
                    <select name="category" id="" class="form-control">
                        <?php foreach ($data as $item): ?>
                            <option <?= $item['id'] === $model['category_id'] ? "selected" : '' ?> value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-4">
                    <label for="features">Tính năng:</label>
                    <input type="text" class="form-control" id="features" name="features"
                           placeholder="Tính năng..." value="<?= $model['product_features'] ?>">
                </div>
                <div class="form-group mt-4">
                    <label for="description">Mô tả:</label>
                    <textarea class="form-control" id="description" name="description" rows="5"
                              placeholder="Viết mô tả..."> <?= $model['product_description'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-4">

                <button type="submit" class="btn btn-primary" >Lưu</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
