<?php
require_once '../models/Product.php';
session_start();

$order_id = $_GET['id'];
$order = getOrders($order_id);

$productId = $order->product_id;

$product = getProduct($productId);






?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" /> 
    <link rel="stylesheet" href="style.css?v=1" />
    <link rel="stylesheet" href="View_orderInfo.css" />
    <link
      href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dahboard | order infomations</title>

  </head>
  <body>
    <div class="container">
      <?php include 'menu.php'; ?>

      <div class="content">
        <nav>
          <div class="messageWelcome">
            <h2>welcome back farah hamoudane !</h2>
            <p>View orders</p>
          </div>
          <hr />
          <div class="navorders">
            <h3>Orders</h3>
            <div class="btn">
                <a href="orders.php" >All oreder</a>
               <a href=""  type="button" onclick="printInvoice()">Print Invoice</a>
            </div>
          </div>
        </nav>

     <div class="Invoice_print">
           <div class="invoice_nav">
            <div class="logo">
                <img src="logo.png" alt="">
            </div>

            <div class="invoice_date">
               <span><?= date('d/m/Y'); ?></span>

            </div>
        </div>
        <div class="invoice">
            <div class="info">
                <h1><?= $order->fullname ?></h1>
                <p><?= $order->phone ?></p>
                <p><?= $order->email ?></p>
                <p><?= $order->address ?></p>
            </div>

            <div class="info">
                    <img src="../<?= $product->productImg ?>" alt="">
            </div>
        </div>
    <div class="table">
          <div class="table-wrapper">
          <table>
            <tr>
              <th>Product name</th>
              <th>Amount</th>
              <th>Duree</th>
              <th>Date created</th>
              
            </tr>

           
            <tr>
                <td><?= $product->productName ?></td>
                <td><?= $order->amount . " MAD" ?></td>
                <td><?= $order->duree . " Day's"?></td>
                <td><?= $order->date_created ?></td>
                
            </tr>
       
           
             
       
             
      
           
          </table>
          </div>
        </div>
     </div>




        </div>
    </div>




        <script>
                function printInvoice() {
                    // Get the invoice content
                    var invoiceContent = document.querySelector('.Invoice_print').innerHTML;
                    
                    // Open a new window
                    var printWindow = window.open('', '', 'width=800,height=600');
                    
                    // Write the invoice HTML into the new window
                    printWindow.document.write(`
                        <html>
                            <head>
                                <title>handtouch-invoice</title>
                                <link rel="stylesheet" href="View_orderInfo.css">
                                <link rel="stylesheet" href="style.css">
                            </head>
                            <body>
                                ${invoiceContent}
                            </body>
                        </html>
                    `);
                    
                    // Close document and trigger print
                    printWindow.document.close();
                    printWindow.print();
                }
        </script>


    </body>
</html>
