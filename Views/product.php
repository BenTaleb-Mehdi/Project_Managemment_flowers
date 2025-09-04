<?php 
require_once '../controller/productAction.php';
session_start();
$product = displayPro();
$i=1;
if (isset($_SESSION['success'])) {
    showsuccess($_SESSION['success']);
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    showError($_SESSION['error']);
    unset($_SESSION['error']);
}

$cat_id = $_GET['cat_id'] ?? null;

if($cat_id) {
    $product = displayProByCategory($cat_id); 
} else {
    $product = displayPro(); 
}


$product = [];

if(isset($_GET['search']) && !empty($_GET['search'])) {
    $product = searchProduct($_GET['search']);
} else {
     $product = displayPro(); 
}


$selectPro = displaycatProducts();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css?v=4" />
    <link rel="stylesheet" href="product.css?v=8" />
    

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
        <div class="aleart_delete">
          <div class="message">
            <p><i class='bx  bx-info-octagon'  ></i> Are you sure for deleted this product ?</p>
          </div>

          <div class="btns">
            <button class="yes">Yes</button>
            <button class="no">Cancel</button>
          </div>
        </div>
        <nav>
          <div class="messageWelcome">
            <h2>welcome back farah hamoudane !</h2>
            <p>All Product</p>
          </div>
          <hr />
          <div class="navorders">
            <div class="fillter">
              <div class="btnAll">
                <a href=""><i class='bxr  bx-filter'  ></i>  All</a>
              </div>
              <div class="btnSelect">
                <button type="button" id="submitBtn">
                  <span id="selectedProductName">Categories</span>
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
            </div>
           <div class="btns">
              <form action="" method="get">
                <div class="search">
                <i class='bxr  bx-search'  ></i> 
                <input type="search" placeholder="Search Product,Product name ,..." name="search" value="<?= $_GET['search'] ?? '' ; ?>" >
                <button type="submit">search<i class='bxr  bx-search'  ></i> </button>
              </div>
              </form>
              <a href="add_product.php" >Add Product</a>
              <a href="add_categorie.php" >Add Categorie</a>
              
           </div>
          </div>
        </nav>

      <div class="table">
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Product number</th>
          <th>Product img</th>
          <th>Product name</th>
          <th>Product price</th>
          <th>Description</th>
          <th>Statut</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="productTableBody">
        <?php foreach($product as $i => $pro) : ?>
        <tr>
          <td><?= $i+1 ?></td>
          <td><img src="../<?= htmlspecialchars($pro->productImg) ?>" alt="product image"></td>
          <td><?= $pro->productName ?></td>
          <td><?= $pro->productPrice . " MAD" ?></td>
          <td><?= $pro->des ?></td>
          <td><?= $pro->status ?></td>
          <td>
            <span>
              <a href="update_product.php?id=<?= $pro->idPro ?>" class="edit" title="Edit Product"><i class='bx bx-edit'></i></a>
              <a href="delete_product.php?id=<?= $pro->idPro ?>" class="delete" title="Delete Product"><i class='bx bx-trash-alt'></i></a>
            </span>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

      </div>
    </div>


<script src="app.js"></script>
  </body>
</html>
