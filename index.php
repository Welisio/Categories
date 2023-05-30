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

  function getNestedData ($pdo, $categoryNestingTypeIds) {
    global $infiniteNestedArrays;
    $placeholders = implode(',', array_fill(0, count($categoryNestingTypeIds), '?'));
    
    $statement = $pdo->prepare("SELECT * FROM `category` WHERE `nesting_type` = 1 AND `parent_id` IN ($placeholders) ");
    if ($statement->execute($categoryNestingTypeIds)) {
      $categoryNestingType = $statement->fetchAll(PDO::FETCH_ASSOC);
      print_r($categoryNestingType);
      echo '<br>';
      // В конце проверка execute срабатывает плохо, в результате $categoryNestingType возвращает пустой массив 
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

  print_r($infiniteNestedArrays);
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
      <?php foreach($categoryNestingType0 as $nestingType0Elem) { ?>
      <div class="category-block">
        <div class="main-category"><?= $nestingType0Elem['name'] ?></div>
        <div class="sub-categories">
          <?php 
          foreach($categoryNestingType1 as $nestingType1Elem) { 
            
            if ($nestingType1Elem['parent_id'] === $nestingType0Elem['id']) {
              if (in_array($nestingType1Elem['id'], $categoryNestingType1)) {
                echo array_count_values(array_column($categoryNestingType1, 'parent_id'))[$nestingType1Elem['id']];
              }
          ?>
          <div style="margin-left: 15px;" class="sub-sub-category"><?= $nestingType1Elem['name']; ?>
              
          </div>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>

SQL Strings<br>
product-category = '0'<br>
sub-category = 'Apple'<br>
sub-sub-category = 'iphone 14 pro|iphone 14 pro Max'<br>