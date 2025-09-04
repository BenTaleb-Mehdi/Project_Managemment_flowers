<?php
require_once '../controller/productAction.php';
session_start();

$id_order = $_GET['id'] ?? null;

if ($id_order) {
    if (updateOrderStatus($id_order)) {
        $_SESSION['success'] = 'Order Completed successfully!';
    } else {
        $_SESSION['error'] = 'Failed to Completed order.';
    }
}

// Redirect back to orders page (optional)
header('Location: orders.php');
exit;


?>