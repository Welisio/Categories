<?php
try {
  $dsn = "mysql:host=localhost;dbname=categorydb;charset=utf8mb4";
  $pdo = new PDO($dsn,'root','');
  $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  $statement = $pdo->prepare("SELECT `name`,`id` FROM `category` WHERE `type` = 0");

  $statement->execute() ? $product_type0 = $statement->fetchAll(PDO::FETCH_ASSOC) : die('Something went wrong');

  $productType0Ids = array();

  foreach($product_type0 as $element) {
    array_push($productType0Ids, $element['id'])
  }
  
  // $statement = $pdo->prepare("SELECT `name`,`id` FROM `category` WHERE `type` = 1 AND `parent_id` IN () ");
  // print_r($product_type0);
  
} catch (PDOException $e) {
  echo 'Failed to connect to the database: ' . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories</title>
  <link rel="stylesheet" href="main.css">
</head>
<body>
  <div class="space"></div>
  <div class="category-body">
    <div class="categories-wrapper">
      <div class="head-category">
        <img style="width:22px;max-height:30px" src="https://kontakt.az/wp-content/uploads/2022/10/Telefon.png">
        <div>Smartfonlar</div> 
      </div>
      <div class="head-delimiter"></div>
      <div class="head-category">
        <img style="width:22px;max-height:30px" src="https://kontakt.az/wp-content/uploads/2022/10/Saat.png">
        <div>Smart qadjetlər</div>
      </div>
      <div class="head-delimiter"></div>
      <div class="head-category">
        <img style="width:22px;max-height:30px" src="https://kontakt.az/wp-content/uploads/2022/10/Komputer.png">
        <div>Notbuklar, PK, planşetlər</div>
      </div>
    </div>
    <div class="categories-tree">
      <div class="category-block">
        <div class="main-category">Smartfonlar</div>
        <div class="sub-categories">
        </div>
      </div>
      <div class="category-block">
        <div class="sub-category">Apple</div>
        <div class="sub-categories">
          <div class="sub-sub-category">
            iphone 14 pro Max
            <div class="sub-sub-category" style="margin-left: 15px">Red</div>
          </div>
          <div class="sub-sub-category">iphone 14 pro Max</div>
          <div class="sub-sub-category">iphone 14 pro Max</div>
          <div class="sub-sub-category">iphone 14 pro Max</div>
          <div class="sub-sub-category">iphone 14 pro Max</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

SQL Strings<br>
product-category = '0'<br>
sub-category = 'Apple'<br>
sub-sub-category = 'iphone 14 pro|iphone 14 pro Max'<br>