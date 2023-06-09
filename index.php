<?php
// Надо создать вторую таблицу,где буду храниться данные о товарах и привязать их к категориям
try {
  $dsn = "mysql:host=localhost;dbname=categorydb;charset=utf8mb4";
  $pdo = new PDO($dsn,'root','');
  $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  $infiniteNestedArrays = array();
  
  function getCategories ($productType) {
    global $pdo;

    $statement = $pdo->prepare("SELECT * FROM `category` WHERE `product_type` = ?");

    $statement->execute([$productType]) ? $categories = $statement->fetchAll(PDO::FETCH_ASSOC) : die('Something went wrong');

    if (count($categories) === 0) return [];

    $categoriesLink = [...$categories];

    $categories = [];

    return $categoriesLink;
  }

  $smartPhoneCategories = getCategories(0);

  $smartGadjets = getCategories(1);

  $computers = getCategories(2);

  foreach ($infiniteNestedArrays as $item) {
    echo '<br>';
  }

  // function subCategoryRender ($categories, $category, $depth) {
  //   if (inArray($category['id'], $categories)) {
  //     for($index = 0; $index < count($categories); $index++) { 
  //       if ($categories[$index]['parent_id'] === $category['id']) {
  //         echo '<div style="margin-left: '.$depth.'px;" class="sub-sub-category">'.$categories[$index]['name'].'</div>';
  //         subCategoryRender($categories, $categories[$index], $depth + 15);
  //       }
  //     }
  //   }
  // }

  function inArray ($categoryId, $categories) {
    for ($index = 0; $index < count($categories); $index++) {
      if ($categories[$index]['parent_id'] === $categoryId) return true;
    }
  }

  function categoryRender ($categories, $depth) {
    for ($index = 0; $index < count($categories); $index++) {
      echo '<div style="margin-left: '.$depth.'px" class="category">'.$categories[$index]['name'].'</div>';
      if (inArray($categories[$index]['id'], $categories)) {
        categoryRender($categories, $depth + 15);
      }      
    }
  }

  print_r($smartPhoneCategories);

  die();
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
        <div class="categories">
          <?php categoryRender($smartPhoneCategories, 0) ?>
        </div>
    </div>
    <?php die(); ?>
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
