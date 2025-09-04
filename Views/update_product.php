<?php
require_once '../controller/productAction.php';
session_start();

if (!isset($_GET['id'])) {
    header('Location: product.php');
    exit();
}

$productId = $_GET['id'];
$product = getProduct($productId); 

if (!$product) {
    $_SESSION['error'] = "Product not found";
    header('Location: product.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (update_product($productId)) { 
        $_SESSION['success'] = 'Order updated successfully!'; 
        header("Location: product.php?id=" . $productId);
        exit();
    } else {
        $_SESSION['error'] = 'Failed to update order';
        header("Location: product.php?id=" . $productId);
        exit();
    }
}

$selectPro = displaycatProducts();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css?v=3" />
    <link rel="stylesheet" href="update_product.css?v=1" />
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
            <p>Update product</p>
          </div>
          <hr />
          <div class="navorders">
            <h3>Update Products</h3>
            <a href="product.php">All product</a>
          </div>
        </nav>

<form action="" method="post" enctype="multipart/form-data">
    <div class="group_inputs">
        <?php if (!empty($product->productImg)): ?>
                        <img src="../<?php echo htmlspecialchars($product->productImg); ?>" alt="Product Image" width="30">
        <?php endif; ?>
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
                <input type="text" placeholder="Enter a product name" name="productName" value="<?= $product->productName ?>">
                 <label>Choose an option:</label>
              <div class="btnSelect">
                <button type="button" id="submitBtn">
                  <span id="selectedProductName">Select</span>
                  <i class='bx  bx-caret-down down'></i> 
                  <i class='bx  bx-caret-up up' style="display: none;"></i> 
                </button> 

                <div class="options">
                  <?php foreach($selectPro as $pro) : ?>
                    <div class="option"  data-id="<?= $pro->id ?>" data-name="<?= htmlspecialchars($pro->name_cat) ?>">
                      <div class="info">
                        <h2><?= $pro->name_cat; ?></h2>
                     
                      </div>
                      <img src="../<?= $pro->img_cat ?>" alt="Flower" >
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <input type="hidden" name="id" id="product_id" value="<?= $product->categorie_id ?>">
              <input type="hidden" name="product_name" id="product_name" value="<?= htmlspecialchars($product->name_cat) ?>">

            </div>
            <div class="input">
                <label for="">product price</label>
                <input type="text" placeholder="Enter a product price " name="productPrice" value="<?= $product->productPrice ?>">
            </div>
        </div>

          <div class="des">
                <label for="">Add descreption </label>
                <textarea name="des" id="" placeholder="Enter a description"><?= $product->des ?></textarea>
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

document.querySelectorAll(".option").forEach((option) => {
  option.addEventListener("click", () => {
    const catId = option.getAttribute("data-id");
    const catName = option.getAttribute("data-name");

    selectedProductName.textContent = catName;
    options.classList.remove("active");
    iconDown.style.display = "block";
    iconUp.style.display = "none";

        document.getElementById("product_id").value = catId;
    document.getElementById("product_name").value = catName;
  })
});


setupDeleteButtons();

    </script>
  </body>
</html>
