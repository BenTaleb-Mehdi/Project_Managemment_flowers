<?php
require_once '../controller/productAction.php';
session_start();

$id_order = $_GET['id'] ?? null;

if ($id_order) {
    if (updateOrderStatusx($id_order)) {
        $_SESSION['error'] = 'Order InCompleted successfully!';
    } else {
        $_SESSION['success'] = 'Failed to InCompleted order.';
    }
}

// Redirect back to orders page (optional)
header('Location: orders.php');
exit;


?>