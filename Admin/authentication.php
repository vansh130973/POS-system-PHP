<?php 

if(isset($_SESSION['loggedIn'])){
  $email = validate($_SESSION['loggedInUser']['email']);

  $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) == 0){
    Redirect('../login.php','Access Denied!');
  }
  else{
    $row = mysqli_fetch_assoc($result);
    if($row['is_ban' == 1]){
      logoutSeesion();
      Redirect('../login.php','Your Account has been banned! Please Contect admin.');
    }
  }

}
else{
  Redirect('../login.php','loggin to continue...');
}

?>