<?php
  require_once '../controller/productAction.php';
  require_once '../models/Product.php';
session_start();

$i = 1;
if (isset($_SESSION['success'])) {
    showsuccess($_SESSION['success']);
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    showError($_SESSION['error']);
    unset($_SESSION['error']);
}

$orders = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $orders = searchOrders($_GET['search']);
} else {
    $orders = displayOdrers(); 
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" /> 
    <link rel="stylesheet" href="style.css?v=3" />
    <link rel="stylesheet" href="Orders.css?v=7" />
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
            <p><i class='bx  bx-info-octagon'  ></i> Are you sure for delete this Order ?</p>
          </div>

          <div class="btns">
            <button class="yes">Yes</button>
            <button class="no">Cancel</button>
          </div>
        </div>
        <nav>
          <div class="messageWelcome">
            <h2>welcome back farah hamoudane !</h2>
            <p>All orders</p>
          </div>
          <hr />
          <div class="navorders">
            <h3>Orders</h3>
           <div class="nav-controller">
            <form action="" method="get">
               <div class="search">
                <i class='bxr  bx-search'  ></i> 
              <input type="search" placeholder="Search Orders,Order name ,..." name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" >
              <button type="submit" >search<i class='bxr  bx-search'  ></i> </button>
            </div>
            </form>
             
            <a href="add_order.php" >Add oreder</a>
           </div>
          </div>
        </nav>

        <div class="table">
          <div class="table-wrapper">
          <table>
            <tr>
              <th>#</th>
              <th>Customer</th>
              <th>Phone number</th>
              <th>Product image</th>
              <th>Product name</th>
              <th>Amount</th>
              <th>Duree</th>
              <th>statut</th>
         
              <th></th>
            </tr>

            <?php foreach($orders as $order) : ?>
            <tr>
              <td class="idPro"><?= $i++ ?></td>
              <td><?= $order->fullname ?></td>
              <td><?= $order->phone ?></td>
              <td><img src="../<?= getProductImg($order->product_id); ?>" alt="" ></td>
              <td><?= getProductName($order->product_id) ?></td>
              <td><?= $order->amount . "<span style='color: green; font-weight : 400'> MAD</span>" ?></td>
              <td><?= $order->duree . " <span style='black: green; font-weight : 500'> Day's</span>" ?></td>
              <?php if($order->satatus_order === "Completed"): ?>
                  <td ><span class="com" ><?= $order->satatus_order ?></span></td>
              <?php else :  ?>
                <td ><span class="incom"><?= $order->satatus_order ?></span></td>
               <?php endif; ?>   
              <td>
                  <a href="update_order.php?id=<?= $order->id ?>"class="edit" ><i class='bx  bx-edit'  ></i> </a>
                  <a href="delete_order.php?id=<?= $order->id ?>" class="delete" ><i class='bx  bx-trash-alt'  ></i> </a>  
                 <?php if($order->satatus_order === "Completed"): ?>
                    <a href="statusx_orderInfo.php?id=<?= $order->id ?>" class="status_x" ><i class='bx  bx-x'  ></i>  </a>
                <?php else :  ?>
                    <a href="status_orderInfo.php?id=<?= $order->id ?>" class="status" ><i class='bx  bx-check-circle'  ></i>  </a>
               <?php endif; ?>         
                   <a href="view_orderInfo.php?id=<?= $order->id ?>" class="view" ><i class='bx  bx-eye'  ></i> </a>
              </td>
              <?php endforeach; ?>
           
          </table>
          </div>
        </div>
      </div>
    </div>
      <script>
        document.addEventListener("DOMContentLoaded", () => {
  const removeLinks = document.querySelectorAll(".delete");
  const aleart_remove = document.querySelector(".aleart_delete");
  const no = document.querySelector(".no");
  const yes = document.querySelector(".yes");

  let deleteUrl = "";

  // setup delete buttons
  removeLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      deleteUrl = link.getAttribute("href");
      aleart_remove.classList.add("active");
    });
  });

  // cancel button
  no.addEventListener("click", () => {
    aleart_remove.classList.remove("active");
  });

  // yes button
  yes.addEventListener("click", () => {
    window.location.href = deleteUrl;
  });
});


  </script>
  </body>
</html>
