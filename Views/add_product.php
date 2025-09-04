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
    if (addPro()) {
       $_SESSION['success'] = 'product added successfully!'; 
        header('Location: product.php');
      exit();
    } else {
         $_SESSION['error'] = 'Failed to added product';
        showError('Failed to add product');
    }
}

$selectPro = displaycatProducts();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="add_product.css?v=4" />
    <link
      href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css"
      rel="stylesheet"
    />
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
            <p>Add product</p>
          </div>
          <hr />
          <div class="navorders">
            <h3>Products</h3>
            <a href="product.php">All product</a>
          </div>
        </nav>

<form action="" method="post" enctype="multipart/form-data">
    <div class="group_inputs">
        <div class="upImg">
            <label for="imgUpload" class="upimg">
                <div class="info">
                      <i class='bx  bxs-image-landscape'  ></i> 
                      <p>Upload a fileAucun fichier choisi or drag and drop</p>
                      <span>PNG, JPG, GIF up to 10MB</span>
                </div>
            </label>
          <input type="file" id="imgUpload" name="productImg" accept="image/*" style="display: none;">
        </div>

        <div class="inputs">
            <div class="input">
                <label for="">product name</label>
                <input type="text" placeholder="Enter a product name" name="productName">
                   <label>Choose an option:</label>
              <div class="btnSelect">
                <button type="button" id="submitBtn">
                  <span id="selectedProductName">Select</span>
                  <i class='bx  bx-caret-down down'></i> 
                  <i class='bx  bx-caret-up up' style="display: none;"></i> 
                </button> 

                <div class="options">
                  <?php foreach($selectPro as $pro) : ?>
                    <div class="option"  data-id="<?= $pro->id ?>" data-name="<?= htmlspecialchars($pro->name_cat) ?>" ">
                      <div class="info">
                        <h2><?= $pro->name_cat; ?></h2>
                     
                      </div>
                      <img src="../<?= $pro->img_cat ?>" alt="Flower" >
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>

            <input type="hidden" name="categorie_id" id="product_id" required>
            <input type="hidden" name="product_name" id="product_name">
            </div>
            <div class="input">
                <label for="">product price</label>
                <input type="text" placeholder="Enter a product price " name="productPrice">
              
            </div>

        </div>

          <div class="des">
                <label for="">Add descreption </label>
                <textarea name="des" id="" placeholder="Enter a description"></textarea>
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
      

      selectedProductName.textContent = productName;
      options.classList.remove("active");
      iconDown.style.display = "block";
      iconUp.style.display = "none";

      document.getElementById("product_id").value = productId;
      document.getElementById("product_name").value = productName;
    
    });
  });




</script>
  </body>
</html>
