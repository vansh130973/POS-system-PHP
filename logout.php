<?php

require 'config/function.php';

if(isset($_SESSION['loggedIn'])){
  logoutSeesion();
  Redirect('login.php','logged out Successfully.');
}

?>