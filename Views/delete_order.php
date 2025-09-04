<?php 
    require_once '../controller/productAction.php';
    session_start();
    if (!isset($_GET['id'])) {
    header('Location: orders.php');
    exit();
}

    $order_id = $_GET['id'];
$order = DeleteOrder($order_id); 
 
if (!$order) {
    $_SESSION['error'] = "oredr not found";
    header('Location: oreders.php');
    exit();
};

if (deletPro($order_id)) { 
    $_SESSION['success'] = "order deleted successfully";
} else {
    $_SESSION['error'] = "order not found or failed to delete";
}

header('Location: orders.php');
exit();





