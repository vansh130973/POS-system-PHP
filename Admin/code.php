<?php

include('../config/function.php');

if(isset($_POST['saveAdmin'])){
  $name = validate($_POST['name']);
  $email = validate($_POST['email']);
  $password = validate($_POST['password']);
  $phone = validate($_POST['phone']);
  $is_ban = isset($_POST['name']) == true ? 1:0;

  if($name != '' && $email != '' && $password != ''){

    $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
    if($emailCheck){
      if(mysqli_num_rows($emailCheck) == 1){
        Redirect('admins-create.php','Email Already Used by Another User');
      }
    }

    $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

    $data = [
      'name' => $name,
      'email' => $email,
      'password' => $bcrypt_password,
      'phone' => $phone,
      'is_ban' => $is_ban
    ];
    $result = insert('admins',$data);
    if($result){
      Redirect('admins.php','Admin Created Successfully');
    }else{
      Redirect('admins-create.php','Something went wrong!');
    }

  }
  else{
    Redirect('admins-create.php','Please fill required fields.');
  }

}


?>