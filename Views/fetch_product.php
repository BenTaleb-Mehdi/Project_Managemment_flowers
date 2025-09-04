<?php
require_once '../controller/productAction.php';

$cat_id = $_GET['cat_id'] ?? null;

if($cat_id) {
    $products = displayProByCategory($cat_id);
} else {
    $products = displayPro();
}

foreach($products as $i => $pro) {
    echo "<tr>
        <td>" . ($i+1) . "</td>
        <td><img src='../" . htmlspecialchars($pro->productImg) . "' alt='product image'></td>
        <td>{$pro->productName}</td>
        <td>{$pro->productPrice}</td>
        <td>{$pro->des}</td>
        <td>{$pro->status}</td>
        <td>
          <span>
            <a href='update_product.php?id={$pro->idPro}' class='edit' title='Edit Product'><i class='bx bx-edit'></i></a>
            <a href='delete_product.php?id={$pro->idPro}' class='delete' title='Delete Product'><i class='bx bx-trash-alt'></i></a>
          </span>
        </td>
    </tr>";
}
?>
