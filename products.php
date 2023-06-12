<?php
require_once __DIR__ . '/core.php';
try {
    $categoryId = $_GET['category_id'];
    $productType = $_GET['product_type'];
    if ((empty($categoryId) || is_null($categoryId)) || (strlen($productType) === 0 || is_null($productType))) die('Oops no category choosen');
    $statement = $pdo->prepare("SELECT * FROM `product` WHERE `path` LIKE ? AND `product_type` = ?");
    $statement->execute(['%'.$categoryId.'%', $productType]) ? $products = $statement->fetchAll(PDO::FETCH_ASSOC) : die('Something went wrong');
    if (count($products) === 0) {
        echo 'No products';
        die();
    } 
} catch (PDOException $e) {
    echo 'Failed to connect to the database: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/products.css">
</head>
<body>
    <div class="products">
        <?php foreach ($products as $product) { ?>
        <div class="product">
            <img src="<?= $product['image'] ?>" alt="">
            <div class="name"><?= $product['name'] ?></div>
        </div>
        <?php } ?>
    </div>
</body>
</html>