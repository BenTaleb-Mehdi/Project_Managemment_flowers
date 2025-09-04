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
    if (addcategoriePro()) {
       $_SESSION['success'] = 'product added successfully!'; 
        header('Location: product.php');
      exit();
    } else {
         $_SESSION['error'] = 'Failed to added product';
        showError('Failed to add product');
    }
}




?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="add_categorie.css" />
    <link
      href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dahboard | Categorie</title>
  </head>
  <body>
    <div class="container">
     <?php include 'menu.php'; ?>

      <div class="content">

        <nav>
          <div class="messageWelcome">
            <h2>welcome back farah hamoudane !</h2>
            <p>Add Categorie</p>
          </div>
          <hr />
          <div class="navorders">
            <h3>Categorie</h3>
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
          <input type="file" id="imgUpload" name="cat_img" accept="image/*" style="display: none;">
        </div>

        <div class="inputs">
            <div class="input">
                <label for="">product name</label>
                <input type="text" placeholder="Enter a product name" name="cat_name">
            </div>
            

          
        </div>

       
    </div>

     <button type="submit" class="btn_add">Add Categorie</button>
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
