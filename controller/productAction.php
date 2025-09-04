<?php
require_once '../models/Product.php';

function addPro() {
  return addProduct();
}
function addcategoriePro() {
  return addCategorieProduct();
}
function displayPro() {
  return displayProducts();
}
function displaycategoriePro() {
  return displaycatProducts();
}

function Addorder(){
    return addOrders();
}
function insertOrder($fullname, $phone, $product_id, $amount, $duree, $email, $address, $country,$status_delete) {
    $pdo = connection_database();

    $sql = "INSERT INTO orders (fullname, phone, product_id, amount, duree, email, address, country, status_delete)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?. ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$fullname, $phone, $product_id, $amount, $duree, $email, $address, $country,$status_delete]);
}

function DisplayOrder(){
    return displayOdrers();
}

function showError($message) {
    echo '
    <div class="flash-message error-message" id="flash-message">
          <i class="bx  bx-info-octagon"  ></i> ' . htmlspecialchars($message) . '
     
    </div>
    <script>

        const flash = document.getElementById("flash-message");
        setTimeout(() => {
            flash.classList.add("show");
        }, 100);

        setTimeout(() => {
            if (flash) {
                flash.classList.remove("show"); // يبدأ بالخروج (يرجع يميناً)
            }
        }, 5000); // يبدأ الاختفاء بعد 9 ثواني

      
    </script>
    ';
}
function showsuccess($message) {
    echo '
    <div class="flash-message success-message" id="flash-message">
         <i class="bx  bx-check-circle"  ></i>  ' . htmlspecialchars($message) . '
    </div>
    <script>
        const flash = document.getElementById("flash-message");

        setTimeout(() => {
            flash.classList.add("show"); 
        }, 100);

        setTimeout(() => {
            if (flash) {
                flash.classList.remove("show");
            }
        }, 5000);

       
        setTimeout(() => {
            if (flash) {
                flash.remove(); 
            }
        }, 5500);
    </script>
    ';
}


function update_product($id) {
    $pdo = connection_database();

    $product_name  = $_POST['productName'];
    $product_price = $_POST['productPrice'];
    $product_des   = $_POST['des'];
    $categori_id = $_POST['id'];

    $product_img = null;

    if (!empty($_FILES['productImg']['name'])) {
        $filename = time() . '_' . basename($_FILES['productImg']['name']);
        $targetPath = __DIR__ . "/../uploads/" . $filename;

        if (move_uploaded_file($_FILES['productImg']['tmp_name'], $targetPath)) {
            $product_img = 'uploads/' . $filename; // خزن المسار النسبي في DB
        } else {
            // رفع الصورة فشل
            $product_img = null;
        }
    }

    if ($product_img) {
        $sql = "UPDATE product SET productImg = ?, productName = ?, productPrice = ?, des = ? , categorie_id = ? WHERE idPro = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$product_img, $product_name, $product_price, $product_des,$categori_id,  $id]);
    } else {
        $sql = "UPDATE product SET productName = ?, productPrice = ?, des = ?, categorie_id = ? WHERE idPro = ? ";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$product_name, $product_price, $product_des,$categori_id, $id]);
    }
}


function deletPro($id){
   return Deleteproduct($id);
}


function DeleteOrder($id){
   return DeleteOrders($id);
}


function updateOrder($id){
        $pdo = connection_database();

        $fullname  = $_POST['fullname'];
        $phone  = $_POST['phone'];
        $product_id = $_POST['product_id'] ?? null; 
        $amount  = $_POST['amount'];
        $duree  = $_POST['duree'];
        $email  = $_POST['email'];
        $address  = $_POST['address'];
        $country  = $_POST['country'];

         $sql = "UPDATE orders SET fullname = ?, phone = ?, product_id = ? , amount = ?, duree = ?, email = ?, `address` = ?, country = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$fullname, $phone,$product_id, $amount, $duree, $email ,$address, $country, $id]);

       

}





function updateOrderStatus($id) {
    $pdo = connection_database();
    $status_update = "Completed";
    $sql = "UPDATE orders SET satatus_order = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$status_update, $id]);
}

function updateOrderStatusx($id) {
    $pdo = connection_database();
    $status_update = "InCompleted";
    $sql = "UPDATE orders SET satatus_order = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$status_update, $id]);
}



