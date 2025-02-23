<?php 

include('../config/function.php');

if(!isset($_SESSION['productItems'])){
  $_SESSION['productItems'] = [];
}

if(!isset($_SESSION['productItemsIds'])){
  $_SESSION['productItemsIds'] = [];
}

if(isset($_POST['addItem'])){
  $productId = validate($_POST['product_id']);
  $quantity = validate($_POST['quantity']); // Corrected variable name

  // Corrected SQL query syntax (removed '=' from LIMIT)
  $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
  
  if($checkProduct){
    if(mysqli_num_rows($checkProduct) > 0){
      $row = mysqli_fetch_assoc($checkProduct);
      
      if($row['quantity'] < $quantity){
        Redirect('order-create.php', 'Only ' . $row['quantity'] . ' quantity available');
      }
      
      $productData = [
        'product_id' => $row['id'],
        'name' => $row['name'],
        'image' => $row['image'],
        'price' => $row['price'],
        'quantity' => $quantity,
      ];

      if(!in_array($row['id'], $_SESSION['productItemsIds'])) {
        array_push($_SESSION['productItemsIds'], $row['id']);
        array_push($_SESSION['productItems'], $productData);
      } else {
        foreach($_SESSION['productItems'] as $key => $prodSessionItem){
          if($prodSessionItem['product_id'] == $row['id']){
            $newQuantity = $prodSessionItem['quantity'] + $quantity;
            
            $productData['quantity'] = $newQuantity;
            $_SESSION['productItems'][$key] = $productData;
          }
        }
      }

      Redirect('order-create.php', 'Item Added: ' . $row['name']);
    } else {
      Redirect('order-create.php', 'No such product found!');
    }
  } else {
    Redirect('order-create.php', 'Something went wrong!');
  }
}

if(isset($_POST['productIncDec']))
{
  $productId = validate($_POST['product_id']);
  $quantity = validate($_POST['quantity']);

  $flag = false;
  foreach($_SESSION['productItems'] as $key => $item){
  $flag = false;
    if($item['product_id'] == $productId){
      $flag = true;
      $_SESSION['productItems'][$key]['quantity'] = $quantity;
    }
  }
  if($flag){
    jsonResponse(200,'success','Quantity Upadated');
  }else{
    jsonResponse(500,'error','Something Went Wrong. Please re-fresh');
  }

}


?>