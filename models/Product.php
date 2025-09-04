<?php
function connection_database() {
    return new PDO('mysql:host=localhost;port=3307;dbname=managemnt_flowers_handtouch', 'root', '');
}
function addOrders(){
      $pdo = connection_database();
        $fullname = $_POST['fullname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $product_id = $_POST['product_id'] ?? '';
        $product_name = $_POST['product_name'] ?? '';
        $product_price = $_POST['product_price'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $duree = $_POST['duree'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';
        $country = $_POST['country'] ?? '';
        $status_delete = 'Active';
       $sql = "INSERT INTO orders (fullname, phone, product_id, amount, duree, email, address, country,status_delete)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$fullname, $phone, $product_id, $amount, $duree, $email, $address, $country ,$status_delete]);
}
function addProduct() {
    $pdo = connection_database();

    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $ProductDes = $_POST['des'];
    $status = "active";
    $imgName = $_FILES['productImg']['name'];
    $imgTmp = $_FILES['productImg']['tmp_name'];
    $categorie_id = $_POST['categorie_id'];
    $uploadDir = __DIR__ . '/../uploads/';
    $uploadPath = $uploadDir . basename($imgName);
    $relativePathForDB = 'uploads/' . basename($imgName);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!is_uploaded_file($imgTmp)) {
        return false;
    }

    if (move_uploaded_file($imgTmp, $uploadPath) && !empty($productName) && !empty($productPrice) && !empty($ProductDes) && !empty($categorie_id) ) {
        $stmt = $pdo->prepare("INSERT INTO product (productImg, productName, productPrice, des,status,categorie_id) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$relativePathForDB, $productName, $productPrice, $ProductDes,$status,$categorie_id]);
    } else {
        return false;
    }
}

function displayProducts() {
    $pdo = connection_database();
 return $pdo->query("SELECT * FROM product WHERE status = 'active' ORDER BY idPro DESC")->fetchAll(PDO::FETCH_OBJ);
}

function displaycatProducts() {
    $pdo = connection_database();
 return $pdo->query("SELECT * FROM categoris_products ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
}

function getProduct($id) {
    $pdo = connection_database();
    $stmt = $pdo->prepare("SELECT * FROM product WHERE idPro = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}


function getProductName($id) {
    $pdo = connection_database();
    $stmt = $pdo->prepare("SELECT * FROM product WHERE idPro = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    return $row ? $row->productName : null;
}
function getProductImg($id) {
    $pdo = connection_database();
    $stmt = $pdo->prepare("SELECT * FROM product WHERE idPro = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);
   return $row ? $row->productImg : null;
}

function displayOdrers() {
    $pdo = connection_database();
    return $pdo->query("SELECT * FROM orders where status_delete = 'Active' ORDER BY id DESC ")->fetchAll(PDO::FETCH_OBJ);
}



function Deleteproduct($id) {
      $pdo = connection_database();
    $stmt = $pdo->prepare("UPDATE product SET status = 'inactive' WHERE idPro = ?");
    return $stmt->execute([$id]);
}
function DeleteOrders($id) {
    $pdo = connection_database();
    $stmt = $pdo->prepare("UPDATE orders SET status_delete = 'inactive' WHERE id = ?");
    return $stmt->execute([$id]);
}


function getOrders($id){
        $pdo = connection_database();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
         return $stmt->fetch(PDO::FETCH_OBJ);
}


function getOrdersTotal() {
    $pdo = connection_database();
    $stmt = $pdo->prepare("SELECT COUNT(id) AS total FROM orders where status_delete = 'Active'");
    $stmt->execute(); // Execute the query
    $row = $stmt->fetch(PDO::FETCH_OBJ); // Fetch the result as an object
    return $row->total; // Return the total count
}

function getProductToatal() {
    $pdo = connection_database();
    $stmt = $pdo->prepare("SELECT COUNT(idPro) AS total FROM product where `status` = 'active' ");
    $stmt->execute(); // Execute the query
    $row = $stmt->fetch(PDO::FETCH_OBJ); // Fetch the result as an object
    return $row->total; // Return the total count
}


function getBalancesum() {
    $pdo = connection_database();
    $stmt = $pdo->prepare("SELECT SUM(amount) AS sum FROM orders WHERE status_delete = 'active'");
    $stmt->execute(); // Execute the query
    $row = $stmt->fetch(PDO::FETCH_OBJ); // Fetch the result as an object
    return $row->sum; // Return the total count
}


function getOrdersPerDay() {
    $pdo = connection_database();

    // Create an array with all days of the week starting Monday
    $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    $counts = array_fill_keys($daysOfWeek, 0);

    $stmt = $pdo->query("
        SELECT DAYNAME(date_created) AS day, COUNT(*) AS totalOrders
        FROM orders
        GROUP BY DAYNAME(date_created)
    ");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Merge counts with days
    foreach ($data as $row) {
        $counts[$row['day']] = (int) $row['totalOrders'];
    }

    return array_values($counts);
}

function getProductsPerDay() {
    $pdo = connection_database();

    $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    $counts = array_fill_keys($daysOfWeek, 0);

    $stmt = $pdo->query("
        SELECT DAYNAME(date_created) AS day, COUNT(*) AS totalProduct
        FROM product
        GROUP BY DAYNAME(date_created)
    ");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $row) {
        $counts[$row['day']] = (int) $row['totalProduct'];
    }

    return array_values($counts);
}


function getBalancePerDay() {
    $pdo = connection_database();

    $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    $counts = array_fill_keys($daysOfWeek, 0);

    $stmt = $pdo->query("
        SELECT DAYNAME(date_created) AS day, SUM(amount) AS totalBalance
        FROM orders
        GROUP BY DAYNAME(date_created)
    ");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $row) {
        $counts[$row['day']] = (int) $row['totalBalance'];
    }

    return array_values($counts);
}


function getStatusOrdersCompleted() {
    $pdo = connection_database();

    // Use the actual column name in your DB
    $stmt = $pdo->query("SELECT COUNT(satatus_order) AS total FROM orders WHERE satatus_order = 'Completed' and status_delete = 'Active'");
    
    if ($stmt) {
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->total;
    }

    return 0; // Return 0 if query fails
}



function getstatusOrders() {
    $pdo = connection_database();

    // Use the actual column name in your DB
    $stmt = $pdo->query("SELECT COUNT(satatus_order) AS total FROM orders WHERE status_delete = 'Active'");
    
    if ($stmt) {
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->total;
    }

    return 0; // Return 0 if query fails
}



function addCategorieProduct() {
    $pdo = connection_database();


    $cat_name = $_POST['cat_name'];
    $imgName = $_FILES['cat_img']['name'];
    $imgTmp = $_FILES['cat_img']['tmp_name'];

    $uploadDir = __DIR__ . '/../uploads/';
    $uploadPath = $uploadDir . basename($imgName);
    $relativePathForDB = 'uploads/' . basename($imgName);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!is_uploaded_file($imgTmp)) {
        return false;
    }

    if (move_uploaded_file($imgTmp, $uploadPath) && !empty($cat_name) ) {
        $stmt = $pdo->prepare("INSERT INTO categoris_products (img_cat, name_cat) VALUES (?, ?)");
        return $stmt->execute([$relativePathForDB, $cat_name]);
    } else {
        return false;
    }



}


function displayProByCategory($cat_id) {
    $pdo = connection_database();
    $stmt = $pdo->prepare("SELECT * FROM product WHERE status = 'active' AND categorie_id = ? ORDER BY idPro DESC");
    $stmt->execute([$cat_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}




function searchProduct($keyword){
    $pdo = connection_database();
    $searchTerm = "%" . $keyword . "%"; 
    $stmt = $pdo->prepare("SELECT * FROM product WHERE  status = 'Active' AND productName LIKE ? OR productprice LIKE ? ");
    $stmt->execute([$searchTerm,$searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function searchOrders($keyword){
    $pdo = connection_database();
    $searchTerm = "%" . $keyword . "%"; 
    $stmt = $pdo->prepare("SELECT * FROM orders 
            WHERE status_delete = 'Active' 
            AND (fullname LIKE ? OR phone LIKE ? OR email LIKE ? OR amount like ? OR duree like ?)");
    $stmt->execute([$searchTerm,$searchTerm,$searchTerm,$searchTerm,$searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}



function getOrdersCompletedLastWeek() {
    $pdo = connection_database();

    // All days of the week starting Monday
    $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    $counts = array_fill_keys($daysOfWeek, 0);

    // Query completed orders from last week grouped by day
    $stmt = $pdo->query("
        SELECT DAYNAME(date_created) AS day, COUNT(*) AS totalOrders
        FROM orders
        WHERE satatus_order = 'Completed'
          AND status_delete = 'Active'
          AND YEARWEEK(date_created, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)
        GROUP BY DAYNAME(date_created)
    ");

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Map results to $counts array
    foreach ($data as $row) {
        $counts[$row['day']] = (int) $row['totalOrders'];
    }

    return array_values($counts); // returns 7 numbers Monday-Sunday
}


function getOrdersCancelsLastWeek() {
    $pdo = connection_database();

    // All days of the week starting Monday
    $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    $counts = array_fill_keys($daysOfWeek, 0);

    // Query canceled/incomplete orders from last week grouped by day
    $stmt = $pdo->query("
        SELECT DAYNAME(date_created) AS day, COUNT(*) AS totalOrders
        FROM orders
        WHERE satatus_order = 'InCompleted'
          AND status_delete = 'inactive'
          AND YEARWEEK(date_created, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)
        GROUP BY DAYNAME(date_created)
    ");

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Map results to $counts array
    foreach ($data as $row) {
        $counts[$row['day']] = (int) $row['totalOrders'];
    }

    return array_values($counts); // returns array of 7 numbers Monday-Sunday
}



function getTotal_Order_lastmonth(){
    $pdo = connection_database();
   $stmt = $pdo->query("SELECT COUNT(*) AS total_orders_last_month
        FROM orders
        WHERE date_created >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-01')
          AND date_created < DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')
    ");

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data['total_orders_last_month'];
}



function getTotal_Product_lastmonth(){
    $pdo = connection_database();
   $stmt = $pdo->query("SELECT COUNT(*) AS total_product_last_month
        FROM product
        WHERE date_created >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-01')
          AND date_created < DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')
    ");

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data['total_product_last_month'];   
}



function getTotal_Ecoms_lastmonth(){
    $pdo = connection_database();
   $stmt = $pdo->query("SELECT SUM(amount) AS total_Ecoms_last_month
        FROM orders
        WHERE date_created >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-01')
          AND date_created < DATE_FORMAT(CURRENT_DATE, '%Y-%m-01') AND satatus_order = 'Completed'
          AND status_delete = 'Active'
    ");

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data['total_Ecoms_last_month'];
}


function getTopProducts($limit = 4) {
    $pdo = connection_database(); // your PDO connection

      $stmt = $pdo->prepare("SELECT p.productName, SUM(o.amount) AS total_sales
        FROM orders o
        JOIN product p ON o.product_id = p.idPro
        WHERE o.satatus_order = 'Completed'
          AND o.status_delete = 'Active'
        GROUP BY p.productName
        ORDER BY total_sales DESC
        LIMIT :limit
    ");

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getPercentageNewOrders() {
    $pdo = connection_database(); // your PDO connection

    // Count orders from last month
    $stmtLastMonth = $pdo->prepare("SELECT COUNT(*) AS last_month_orders
        FROM orders
        WHERE MONTH(date_created) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
          AND YEAR(date_created) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND status_delete = 'Active'
    ");
    $stmtLastMonth->execute();
    $lastMonthOrders = $stmtLastMonth->fetch(PDO::FETCH_ASSOC)['last_month_orders'];

    // Count all orders
    $stmtAll = $pdo->prepare("SELECT COUNT(*) AS all_orders FROM orders");
    $stmtAll->execute();
    $allOrders = $stmtAll->fetch(PDO::FETCH_ASSOC)['all_orders'];

    if ($allOrders == 0) return 0; // avoid division by zero

    $percentage = ($lastMonthOrders / $allOrders) * 100;
    return round($percentage, 2);
}
