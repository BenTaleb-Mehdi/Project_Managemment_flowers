<?php
require_once '../controller/productAction.php';
session_start();

$total_ordres = getOrdersTotal();
$total_product = getProductToatal();
$sum_balance = getBalancesum();
$totla_statut = getstatusOrders();
$totla_statutcom = getStatusOrdersCompleted();
$status_ordersComplted = ($totla_statutcom/$totla_statut) * 100;

$orderCounts   = getOrdersPerDay();
$procutCounts = getProductsPerDay();
$BalanceSum = getBalancePerDay();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" /> 
   

 <link rel="stylesheet" href="dashboard.css?v=3" />
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
            <p>Oreview Dashboard</p>
          </div>
        </nav>
  <div class="boxese">
            <div class="box">
                <div class="info">
                    <p>Orders</p>
                    <span><h1><?= $total_ordres; ?></h1><p>Total Orders</p></span>
                </div>

                <div class="icon">
                   <i class='bx  bx-package'  ></i> 
                </div>
            </div>

            <div class="box">
                <div class="info">
                    <p>Products</p>
                    <span><h1><?= $total_product; ?></h1><p>Total product</p> </span>
                </div>

                <div class="icon">
                   <i class='bx  bx-shopping-bag-alt'  ></i> 
                </div>
            </div>

            <div class="box">
                <div class="info">
                    <p>Balance</p>
                    <span><h1><?= $sum_balance ?></h1><p>MAD Sum Ecoms</p></span>
                </div>

                <div class="icon">
                   <i class='bx  bx-wallet-alt'  ></i> 
                </div>
            </div>

            <div class="box">
                <div class="info">
                    <p>Tasks not completed</p>
                    <span><h1>10</h1><p>in last week</p></span>
                </div>

                <div class="icon">
                    <i class='bx  bx-list-x'  ></i> 
                </div>
            </div>
  </div>
       
<div class="anlyses">
    
    <div class="chart">
        <p><i class='bx  bx-chart-spline'  ></i>Orders and Ecoms in a week</p>
        <div id="chart"></div>
    </div>
    <div class="chart">
      <p><i class='bx  bx-tachometer-alt'  ></i> Orders completed</p>
        <div id="chart2"></div>
    </div>
</div>








        </div>

      </div>
   <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>

        var options = {
        chart: {
            type: 'line'
        },
        series: [
            {
            name: 'Orders',
           data: <?= json_encode($orderCounts); ?>
            },
            {
                name: 'products',
                data: <?= json_encode($procutCounts); ?>
            }, {
                name: 'Ecoms',  
                data: <?= json_encode($BalanceSum); ?>
            },
        ],
        xaxis: {

            categories:  ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday']
        }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();

        var options = {
        chart: {
            height: 380,
            type: "radialBar"
        },
        colors: ["#1eff29ff"], 
         series: [<?= round($status_ordersComplted, 2) ?>], 
        
        plotOptions: {
            radialBar: {
            hollow: {
                margin: 20,
                size: "70%"
            },
            
            dataLabels: {
                showOn: "always",
                name: {
                offsetY: -10,
                show: true,
                color: "#888",
                fontSize: "13px"
                },
                value: {
                color: "#111",
                fontSize: "30px",
                show: true
                }
            }
            }
        },

        stroke: {
            lineCap: "round",
        },
        labels: ["Progress"]
        };

        var chart2 = new ApexCharts(document.querySelector("#chart2"), options);

        chart2.render();

    </script>
    </body>
</html>