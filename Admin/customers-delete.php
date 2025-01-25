<?php

require '../config/function.php';

$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

  $customerId = validate($paraResultId);
  
  $customer = getById('customers',$customerId);
  
  if($customer['status'] == 200){
    $response = delete('customers',$customerId);

    if($response){
      Redirect('customers.php','Customer Deleted Successfully.');
    }
    else{
      Redirect('customers.php','Something Went Wrong.');
    }
  }else{
    Redirect('customers.php',$customer['message']);
  }

  // echo $adminId;

}else{
  Redirect('customers.php','Something Went Wrong.');
}

?>