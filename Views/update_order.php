<?php
require_once '../models/Product.php';
require_once '../controller/productAction.php';
session_start();
$id_order = $_GET['id'];
$order = getOrders($id_order);

 



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (updateOrder($id_order)) { 
        $_SESSION['success'] = 'Order updated successfully!'; 
        header("Location: orders.php?id=" . $id_order);
        exit();
    } else {
        $_SESSION['error'] = 'Failed to update order';
        header("Location: orders.php?id=" . $id_order);
        exit();
    }
}
$selectPro = displayPro();



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css?v=2" />
    <link rel="stylesheet" href="update_order.css">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dahboard | Home</title>
  </head>
  <body>
    <div class="container">
      <?php include 'menu.php'; ?>

      <div class="content">
        <nav>
          <div class="messageWelcome">
            <h2>welcome back farah hamoudane !</h2>
            <p>Update orders</p>
          </div>
          <hr />
          <div class="navorders">
            <h3>Orders</h3>
            <a href="orders.php" >All Orders</a>
          </div>
        </nav>
        <form action="" method="post">   
          <div class="group_inputs">
            <div class="inputs">

              <label for="Customer">New Customer name</label>
              <input type="text" placeholder="Enter a Customer name" name="fullname" value="<?= $order->fullname ?>" >

              <label for="">New Phone Number</label>
              <input type="text" placeholder="Enter a Phon number" name="phone" value="<?= $order->phone ?>" >

              <label>Choose a New option:</label>
                <div class="btnSelect">
                    <button type="button" id="submitBtn">
                        <span id="selectedProductName">
                            <?= htmlspecialchars($order->productName ?? 'Select') ?>
                        </span>
                        <i class='bx bx-caret-down down'></i> 
                        <i class='bx bx-caret-up up' style="display: none;"></i> 
                    </button> 

                    <div class="options">
                        <?php foreach ($selectPro as $pro) : ?>
                            <div class="option <?= ($pro->idPro == ($order->product_id ?? '')) ? 'active' : '' ?>"  
                                data-id="<?= $pro->idPro ?>" 
                                data-name="<?= htmlspecialchars($pro->productName) ?>" 
                                data-price="<?= htmlspecialchars($pro->productPrice) ?>">

                                <div class="info">
                                    <h2><?= htmlspecialchars($pro->productName); ?></h2>
                                    <span><?= htmlspecialchars($pro->productPrice); ?></span>
                                </div>
                                <img src="../<?= htmlspecialchars($pro->productImg) ?>" alt="Flower">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

              <label for="">New Amount</label>
              <input type="text" placeholder="Enter an amount" name="amount" value="<?= $order->amount ?>">


<input type="hidden" name="product_id" id="product_id" value="<?= htmlspecialchars($order->product_id ?? '') ?>">
<input type="hidden" name="product_name" id="product_name" value="<?= htmlspecialchars($order->productName ?? '') ?>">
<input type="hidden" name="product_price" id="product_price" value="<?= htmlspecialchars($order->productPrice ?? '') ?>">
            </div>

            <div class="inputs">
              
              <label for="">New Duration</label>
              <input type="text" placeholder="Enter a Duration work" name="duree" value="<?= $order->duree ?>">

              <label for="">New Email Address</label>
              <input type="text" placeholder="Enter a Email Address" name="email" value="<?= $order->email ?>">

              <label for="">New Address</label>
              <input type="text" placeholder="Enter a Address" name="address" value="<?= $order->address ?>">

              <label for="">New Country</label>
              <input type="text" placeholder="Enter a Country" name="country" value="<?= $order->country ?>">

            </div>
         
        </div>
        <button type="submit" class="btn_add">Update order</button>
 </form>
      </div>

    </div>
    <script>
  const btn = document.getElementById("submitBtn");
  const options = document.querySelector(".options");
  const iconDown = document.querySelector(".down");
  const iconUp = document.querySelector(".up");
  const selectedProductName = document.getElementById("selectedProductName");

  btn.addEventListener("click", () => {
    options.classList.toggle("active");
    const isActive = options.classList.contains("active");
    iconDown.style.display = isActive ? "none" : "block";
    iconUp.style.display = isActive ? "block" : "none";
  });

  document.querySelectorAll(".option").forEach(option => {
    option.addEventListener("click", () => {
      const productId = option.getAttribute("data-id");
      const productName = option.getAttribute("data-name");
      const productPrice = option.getAttribute("data-price");

      selectedProductName.textContent = productName;
      options.classList.remove("active");
      iconDown.style.display = "block";
      iconUp.style.display = "none";

      document.getElementById("product_id").value = productId;
      document.getElementById("product_name").value = productName;
      document.getElementById("product_price").value = productPrice;
    });
  });




</script>
  </body>
</html>