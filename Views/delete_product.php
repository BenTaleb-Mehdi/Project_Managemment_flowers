<?php 
    require_once '../controller/productAction.php';
    session_start();
    if (!isset($_GET['id'])) {
    header('Location: product.php');
    exit();
}

    $productId = $_GET['id'];
$product = deletPro($productId); 

if (!$product) {
    $_SESSION['error'] = "Product not found";
    header('Location: product.php');
    exit();
};

if (deletPro($productId)) { 
    $_SESSION['success'] = "Product deleted successfully";
} else {
    $_SESSION['error'] = "Product not found or failed to delete";
}

header('Location: product.php');
exit();





