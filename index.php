<?php
try {
  require_once __DIR__ . '/core.php';
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

  function inArray ($categoryId, $categories) {
    for ($index = 0; $index < count($categories); $index++) {     
      if ($categories[$index]['parent_id'] === $categoryId) return true;
    }
  }

  function categoryRender ($categories, $category, $depth) {
      if (inArray($category['id'], $categories)) {
        for($index = 0; $index < count($categories); $index++) { 
          if ($categories[$index]['parent_id'] === $category['id']) {
            echo '
            <a href="products.php?category_id='.$categories[$index]['id'].'&product_type='.$categories[$index]['product_type'].'">
              <div style="margin-left: '.$depth.'px;" class="category">'.$categories[$index]['name'].'</div>
            </a>
            ';
            categoryRender($categories, $categories[$index], $depth + 15);
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
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/category.css">
</head>
<body>
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
      <div class="head-category" onmouseover="showCategories(1)">
        <div class="img-container">
          <img style="width:22px;max-height:30px" src="https://kontakt.az/wp-content/uploads/2022/10/Saat.png">
        </div>
        <div class="img-name">
          <div class="name">Smart qadjetlər</div>       
        </div>
      </div>
    </div>
    <div style="display: block;" class="categories-tree">
      <div class="categories">
        <?php for ($index = 0; $index < count($smartPhoneCategories); $index++) {
          $category = $smartPhoneCategories[$index];
          if (empty($category['parent_id'])) {
        ?>
        <a href="products.php?category_id=<?= $category['id'] ?>&product_type=<?= $category['product_type'] ?>">
          <div class="category"><?= $category['name'] ?></div>
        </a>
        <?php 
            categoryRender($smartPhoneCategories, $category, 15);
          }
        }
        ?>
      </div>
    </div>
    <div style="display: none;" class="categories-tree">
      <div class="categories">
        <?php for ($index = 0; $index < count($smartGadjets); $index++) {
          $category = $smartGadjets[$index];
          if (empty($category['parent_id'])) {
        ?>
        <a href="products.php?category_id=<?= $category['id'] ?>&product_type=<?= $category['product_type'] ?>">
          <div class="category"><?= $category['name'] ?></div>
        </a>
        <?php 
          categoryRender($smartGadjets, $category, 15);
        }
        }
        ?>
      </div>
    </div>
  </div>
  <script src="main.js"></script>
</body>
</html>
