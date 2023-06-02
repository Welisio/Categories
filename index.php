<?php
try {
  $dsn = "mysql:host=localhost;dbname=categorydb;charset=utf8mb4";
  $pdo = new PDO($dsn,'root','');
  $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  $statement = $pdo->prepare("SELECT * FROM `category` WHERE `nesting_type` = 0");

  $statement->execute() ? $categoryNestingType0 = $statement->fetchAll(PDO::FETCH_ASSOC) : die('Something went wrong');

  $categoryNestingType0Ids = array();

  foreach($categoryNestingType0 as $category) {
    array_push($categoryNestingType0Ids, $category['id']);
  }

  $infiniteNestedArrays = array();


  $infiniteNestedArrays[] = $categoryNestingType0;

  function getNestedData ($pdo, $categoryNestingTypeIds) {
    global $infiniteNestedArrays;
    $placeholders = implode(',', array_fill(0, count($categoryNestingTypeIds), '?'));
    
    $statement = $pdo->prepare("SELECT * FROM `category` WHERE `nesting_type` = 1 AND `parent_id` IN ($placeholders) ");
    
    $statement->execute($categoryNestingTypeIds);

    $categoryNestingType = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (count($categoryNestingType)) {
      array_push($infiniteNestedArrays, $categoryNestingType);

      $categoryNestingTypeIds = array();
    
      foreach($categoryNestingType as $category) {
        array_push($categoryNestingTypeIds, $category['id']);
      }

      getNestedData($pdo, $categoryNestingTypeIds);
    } else {
      return;
    }
  }
  
  getNestedData($pdo, $categoryNestingType0Ids);
  $infiniteNestedArrays = array_merge(...$infiniteNestedArrays);
  print_r($infiniteNestedArrays);
  function rendering ($infiniteNestedArrays) {
    foreach($infiniteNestedArrays as $item) {
      if ($item['nesting_type'] ===  0) {
        $childsKeys = array_keys($infiniteNestedArrays, 'parrent');
        echo '<div class="main-category">'.$item['name'].'</div>';
      } else {
        echo '<div style="margin-left: 15px;" class="sub-sub-category">'.$item['name'].'</div>';
      }
    }
    
  }
  $template = '';
  echo $template;
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
      <?php categoriesRecursiveRendering($infiniteNestedArrays) ?>  
    </div>
  </div>
</body>
</html>

SQL Strings<br>
product-category = '0'<br>
sub-category = 'Apple'<br>
sub-sub-category = 'iphone 14 pro|iphone 14 pro Max'<br>