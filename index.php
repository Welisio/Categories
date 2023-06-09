<?php
try {
  $dsn = "mysql:host=localhost;dbname=categorydb;charset=utf8mb4";
  $pdo = new PDO($dsn,'root','');
  $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  $infiniteNestedArrays = array();

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
  
  function getCategories ($productType) {
    global $pdo, $infiniteNestedArrays;

    $statement = $pdo->prepare("SELECT * FROM `category` WHERE `nesting_type` = ? AND `product_type` = ?");

    $statement->execute([0, $productType]) ? $categoryNestingType0 = $statement->fetchAll(PDO::FETCH_ASSOC) : die('Something went wrong');

    if (count($categoryNestingType0) === 0) return [];
  
    $categoryNestingType0Ids = array();
  
    foreach($categoryNestingType0 as $category) {
      array_push($categoryNestingType0Ids, $category['id']);
    }
  
    $infiniteNestedArrays[] = $categoryNestingType0;

    getNestedData($pdo, $categoryNestingType0Ids);

    $infiniteNestedArrays = array_merge(...$infiniteNestedArrays);

    $infiniteNestedArraysLink = [...$infiniteNestedArrays];

    $infiniteNestedArrays = [];

    return $infiniteNestedArraysLink;
  }

  $smartPhoneCategories = getCategories(0);

  $smartGadjets = getCategories(1);

  $computers = getCategories(2);

  foreach ($infiniteNestedArrays as $item) {
    echo '<br>';
  }

  function inArray ($value, $array) {
    for ($i = 0; $i < count($array); $i++) {
      if ($array[$i]['parent_id'] === $value) return true;
    }
  }
  function subCategoryRender ($infiniteNestedArrays, $category, $depth) {
    if (inArray($category['id'], $infiniteNestedArrays)) { 
      for($index = 0; $index < count($infiniteNestedArrays); $index++) { 
        if ($infiniteNestedArrays[$index]['parent_id'] === $category['id']) {
          echo '<div style="margin-left: '.$depth.'px;" class="sub-sub-category">'.$infiniteNestedArrays[$index]['name'].'</div>';
          subCategoryRender($infiniteNestedArrays, $infiniteNestedArrays[$index], $depth + 15);
        }
      }
    }
  }
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
      <div class="head-category" onmouseover="showCategories(0)">
        <div class="img-container">
          <img style="width:22px;max-height:30px;" src="https://kontakt.az/wp-content/uploads/2022/10/Telefon.png">
        </div>
        <div class="img-name">
          <div class="name">Smartfonlar</div>
          <div class="head-delimiter"></div>       
        </div>
      </div>
      <div class="head-category">
        <div class="img-container">
          <img style="width:22px;max-height:30px" src="https://kontakt.az/wp-content/uploads/2022/10/Saat.png">
        </div>
        <div class="img-name">
          <div class="name">Smart qadjetlər</div>       
          <div class="head-delimiter"></div>   
        </div>
      </div>
      <div class="head-category">
        <div class="img-container">
          <img style="width:22px;max-height:30px" src="https://kontakt.az/wp-content/uploads/2022/10/Komputer.png">
        </div>
        <div class="img-name">
          <div class="name">Notbuklar, PK, planşetlər</div>
          <div class="head-delimiter"></div>
        </div>
      </div>
    </div>
    <div style="display: block;" class="categories-tree">
      <?php foreach($smartPhoneCategories as $mainCategory) {   
        if ($mainCategory['nesting_type'] === 0) {  
      ?>
      <div class="category-block">
          <div class="main-category"><?= $mainCategory['name'] ?></div>  
          <div class="sub-categories">
            <?php subCategoryRender($smartPhoneCategories, $mainCategory, 15);?>
          </div>  
      </div>
      <?php
          } 
        } 
      ?>
    </div>
    <div style="display: none;" class="categories-tree">
      <?php foreach($smartGadjets as $mainCategory) {   
        if ($mainCategory['nesting_type'] === 0) {  
      ?>
      <div class="category-block">
          <div class="main-category"><?= $mainCategory['name'] ?></div>  
          <div class="sub-categories">
            <?php subCategoryRender($smartGadjets, $mainCategory, 15);?>
          </div>  
      </div>
      <?php
          } 
        } 
      ?>
    </div>
    <div style="display: none;" class="categories-tree">
      <?php foreach($infiniteNestedArrays as $mainCategory) {   
        if ($mainCategory['nesting_type'] === 0) {  
      ?>
      <div class="category-block">
          <div class="main-category"><?= $mainCategory['name'] ?></div>  
          <div class="sub-categories">
            <?php subCategoryRender($infiniteNestedArrays, $mainCategory, 15);?>
          </div>  
      </div>
      <?php
          } 
        } 
      ?>
    </div>
  </div>
  <script src="main.js"></script>
</body>
</html>