<?php

require '../config/function.php';

$paraResultId = checkParamId('id');
if (is_numeric($paraResultId)) {

  $adminId = validate($paraResultId);
  $admin = getById('admins',$adminId);
  if($admin['status'] == 200){
    $adminDeleteRes = delete('admins', $adminId);
    if($adminDeleteRes){
      Redirect('admins.php','Admin Deleted Successfully.');
    }
    else{
      Redirect('admins.php','Something Went Wrong.');
    }
  }else{
    Redirect('admins.php',$admin['message']);
  }

  // echo $adminId;

}else{
  Redirect('admins.php','Something Went Wrong.');
}

?>