<?php 
    include_once '../models/Product.php';

    $total_ordersComplte = getOrdersCompletedLastWeek();
    $total_ordersCancels = getOrdersCancelsLastWeek();

    $total_orders_last_month = getTotal_Order_lastmonth();
    $total_products_last_month = getTotal_Product_lastmonth();
    $sum_ecoms_last_month = getTotal_Ecoms_lastmonth();

    $topProducts = getTopProducts();
    $getPercentageNewOrders = getPercentageNewOrders();
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" /> 
     <link rel="stylesheet" href="staticstyle.css?v=1" />
    <link
      href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css"
      rel="stylesheet"
    />
      <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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



        <div class="statics">
            <div class="chart-status">
                
                    <p><i class='bx  bx-chart-line'  ></i> chart status orders </p>   
                    <div id="chart"></div>
              
            </div>
            

        <div class="analyses-boxes">
               
                    <p><i class='bx  bx-file-report'  ></i>Total in last month </p> 
            
                <div class="boxes">
                    <div class="box">
                        <div class="static-box">
                            <h2>Total orders</h2>
                            <span><?= $total_orders_last_month; ?> <p><i class='bx  bx-trending-up'  ></i>8% </p></span>
                        
                        </div>
                        <div class="icon-box">
                                <i class='bx  bx-package'  ></i> 
                        </div>
                    </div>

                    <div class="box">
                        <div class="static-box">
                            <h2>Total Product</h2>
                            <span><?= $total_products_last_month; ?> <p><i class='bx  bx-trending-up'  ></i> 8% </p></span>
                        
                        </div>
                        <div class="icon-box">
                            <i class='bx  bx-shopping-bag-alt'  ></i> 
                        </div>
                    </div>

                    <div class="box">
                        <div class="static-box">
                            <h2>Total Ecoms</h2>
                            <span><?= $sum_ecoms_last_month . ' MAD'?> <p><i class='bx  bx-trending-down'  ></i> 8% </p></span>
                        
                        </div>
                        <div class="icon-box">
                                <i class='bx  bx-wallet-alt'  ></i> 
                        </div>
                    </div>

                    <div class="box">
                        <div class="static-box">
                            <h2>Total orders</h2>
                            <span>8,251 <p><i class='bx  bx-trending-up'  ></i>8% </p></span>
                        
                        </div>
                        <div class="icon-box">
                                <i class='bx  bx-package'  ></i> 
                        </div>
                    </div>

                    
                </div>
        </div>




        </div>

        <div class="anlyses-pro">
            <div class="analyses-sellings">
                <p><i class='bx  bx-chart-bar-rows'  ></i> statics Top 4 best Orders</p>
                <div class="content-toporders">
                
        <?php foreach($topProducts as $index => $product) :?>
                    <div class="best-selling">
                        <div class="info">
                            <div class="img-info">
                                <img src="flower.jpeg" alt="">
                            </div>
                            <div class="name-order">
                                <h3><?= $product['productName']  ?></h3>
                                <span><?= $product['total_sales'] . " MAD" ?></span>
                            </div>
                        </div>

                        <div class="icon">
                            <span><?=  "Top " . $index + 1 ?></span>
                        </div>
                    </div>
        <?php endforeach ; ?>

                  

                   
                                    
                </div>
            </div>

           
            



            <div class="chart">
                <p><i class='bx  bx-tachometer-alt'  ></i>  Porcentage new Orders</p>
                <div id="chart2"></div>
            </div>
        </div>



        </div>
    </div>
    <script>
    var options = {
  chart: {
    height: '100%',
    type: "radialBar"
  },
  colors: ["#1eff29ff"], 
  series: [ <?= $getPercentageNewOrders; ?> ],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "80%"
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


    var options = {
        chart: {
            type: 'line',
            height: '100%',
            width: '100%'
        },
        series: [
            {
                name: 'Cancels',
                data: <?= json_encode($total_ordersCancels); ?>
            },
            {
                name: 'Completed',
                data: <?= json_encode($total_ordersComplte); ?>,
            }
        ],
        xaxis: {
            categories:  ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday']
        },
        legend: {
            position: 'bottom',   // top, bottom, left, right
            horizontalAlign: 'center', // left, center, right
            fontSize: '14px',
            labels: {
                colors: '#333' // legend text color
            },
            markers: {
                width: 12,
                height: 12,
                radius: 12
            }
        },
        colors: ['#e74c3c', '#2ecc71'] // red for cancels, green for completed
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
    </script>

    </body>
</html>

