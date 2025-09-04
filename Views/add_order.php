<?php 
require_once '../controller/productAction.php';

session_start();
 
if (isset($_SESSION['success'])) {
    showsuccess($_SESSION['success']);
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    showError($_SESSION['error']);
    unset($_SESSION['error']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (Addorder()) {
       $_SESSION['success'] = 'Order added successfully!'; 
        header('Location: orders.php');
      exit();
    } else {
      $_SESSION['error'] = 'Failed to added order';
        showError('Failed to add product');
    }
}

$selectPro = displayPro();


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css?v=1" />
    <link rel="stylesheet" href="add_order.css?v=3">
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
            <p>add orders</p>
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

              <label for="Customer">Customer name</label>
              <input type="text" placeholder="Enter a Customer name" name="fullname" >

              <label for="">Phone Number</label>
              <input type="text" placeholder="Enter a Phon number" name="phone" >

              <label>Choose an option:</label>
              <div class="btnSelect">
                <button type="button" id="submitBtn">
                  <span id="selectedProductName">Select</span>
                  <i class='bx  bx-caret-down down'></i> 
                  <i class='bx  bx-caret-up up' style="display: none;"></i> 
                </button> 

                <div class="options">
                  <?php foreach($selectPro as $pro) : ?>
                    <div class="option"  data-id="<?= $pro->idPro ?>" data-name="<?= htmlspecialchars($pro->productName) ?>" data-price="<?= htmlspecialchars($pro->productPrice) ?>">
                      <div class="info">
                        <h2><?= $pro->productName; ?></h2>
                        <span><?= $pro->productPrice; ?></span>
                      </div>
                      <img src="../<?= $pro->productImg ?>" alt="Flower" >
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>

            <input type="hidden" name="product_id" id="product_id" required>
            <input type="hidden" name="product_name" id="product_name">
            <input type="hidden" name="product_price" id="product_price">



              <label for="">Amount</label>
              <input type="text" placeholder="Enter an amount" name="amount" >


            </div>

            <div class="inputs">
              
              <label for="">Duration</label>
              <input type="text" placeholder="Enter a Duration work" name="duree" >

              <label for="">Email Address</label>
              <input type="text" placeholder="Enter a Email Address" name="email" >

              <label for="">Address</label>
              <input type="text" placeholder="Enter a Address" name="address" >

              <label for="">Country</label>
              <input type="text" placeholder="Enter a Country" name="country" >

            </div>
         
        </div>
        <button type="submit" class="btn_add">Add order</button>
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
