<?php 

require 'config/function.php';

if(isset($_POST['loginBtn'])){
  $email = validate($_POST['email']);
  $password = validate($_POST['password']);

  if($email != '' && $password != ''){
    $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if($result){
      if(mysqli_num_rows($result) == 1){
        
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        if(!password_verify($password, $hashedPassword)){
          Redirect('login.php','Invalid Password');
        }
        if($row['is_ban'] == 1){
          Redirect('login.php','Your account has been banned. Contect your Admin.');
        }
        $_SESSION['loggedIn'] = true;
        $_SESSION['loggedInUser'] = [
          'user_id' => $row['id'],
          'name' => $row['name'],
          'email' => $row['email'],
          'phone' => $row['phone'],
        ];

        Redirect('admin/index.php','Logged In Successfully');

      }else{
        Redirect('login.php','Invalid Email Address');
      }

    }else{
      Redirect('login.php','Something went wrong!');
    }

  }else{
    Redirect('login.php','All fields are mandetory!');
  }

}

?>