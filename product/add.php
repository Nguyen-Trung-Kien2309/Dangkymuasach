<?php
require_once ('../category/select.php');
global $conn;
if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nameErr = $priceErr=$manufacturerErr=$categoryErr=$featuresErr=$descriptionErr=$pathErr = null;

        $targetFile = '../path/'.time().$_FILES['image']['full_path'];
        $path = time().$_FILES['image']['full_path'];
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        $name = $_POST['name'];
        $price =$_POST['price'];
        $manufacturer = $_POST['manufacturer'];
        $category = $_POST['id_category'];
        $features = $_POST['features'];
        $description =$_POST['description'];
        $sql = '
            INSERT INTO products (name,manufacturer,price,img,id_category,features,description)
            values (:name,:manufacturer,:price,:img,:id_category,:features,:description)
            '
        ;

    
        if (empty($name)) {
            $nameErr = 'Trường tên là bắt buộc';
        }
    
        if (empty($price)) {
            $priceErr = 'Trường danh mục là bắt buộc';
        }
    
        if (empty($manufacturer)  ) {
            $manufacturerErr = 'Trường tổng hành khách là bắt buộc';
        }
    
        // if (empty($description) >1000 ) {
        //     $descriptionErr = 'Trường mô tả tối đa 10000 ký tự';
        // }
    
        
        // if (empty($image)) {
        //     $imageErr = 'Trường ảnh tối đa';
        // }
        // if ($image['size'] > 1024 * 1024 * 2) {
        //     $imageErr = 'Trường ảnh tối đa 2MB';
        // }
    if (empty($nameErr)
            && empty($priceErr)
            && empty($manufacturerErr)
            // && empty($airline_idErr)
            // && empty($imageErr)) 
    )
    {
    




    //     $check  = true;

    //     if (empty($name) || ctype_alpha(str_replace(' ', '', $name)) === false) {
    //         $check = false;
    //         $nameErr = "Trường tên không được để trống";
    //     }
    //     if (empty($price) ) {
    //         $check = false;
    //         $priceErr = "Trường giá không được để trống";
    //     }


    // if($check) {
        try {
            $stmt = $conn->prepare($sql);
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
            <div class="col-md-6">
                <div class="form-group mt-4">
                    <label for="name">Tên:</label>
                    <input type="text" class="form-control" id="name" name="name"  placeholder="Tên sản phẩm...">
                    <span class="text-danger"><?= $nameErr ?? '' ?></span>
                </div>
                <div class="form-group mt-4">
                    <label for="manufacturer">Hãng sản xuất:</label>
                    <input type="text" class="form-control" id="manufacturer" name="manufacturer"
                           placeholder="Hãng....">
                </div>
                <div class="form-group mt-4">
                    <label for="price">Giá:</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Giá.." >
                    <span class="text-danger"> <?= $priceErr ?? '' ?></span>

                </div>
                <div class="form-group mt-4">
                    <label for="image">Ảnh:</label>
                    <input type="file" class="form-control" id="image" name="image" accept=".jpg,.png.jepg" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-4">
                    
                <div>
                            <!-- <p>Tính năng</p>
                            <select name="" id="" value="" name="">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                        </div> -->
                    <label for="id_category">Thể loại:</label>
                    <select name="id_category" id="" class="form-control">
                    <option value="">Nokia</option>
                                <option value="">Smatph</option>
                                <option value="">Samsung</option>
                        <?php foreach ($data as $item): ?>
                            <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mt-4">
                    <label for="features">Tính năng:</label>
                    <input type="text" class="form-control" id="features" name="features"
                           placeholder="Tính năng...">
                </div>
                <div class="form-group mt-4">
                    <label for="description">Mô tả:</label>
                    <textarea class="form-control" id="description" name="description" rows="5"
                              placeholder="Viết mô tả..."> </textarea>
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


