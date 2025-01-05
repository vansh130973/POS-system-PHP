<?php

require '../config/function.php';

$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

  $categoryId = validate($paraResultId);
  
  $category = getById('categories',$categoryId);
  
  if($category['status'] == 200){
    $response = delete('categories',$categoryId);

    if($response){
      Redirect('categories.php','Category Deleted Successfully.');
    }
    else{
      Redirect('categories.php','Something Went Wrong.');
    }
  }else{
    Redirect('categories.php',$category['message']);
  }

  // echo $adminId;

}else{
  Redirect('categories.php','Something Went Wrong.');
}

?>