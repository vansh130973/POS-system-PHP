<?php
session_start();

require 'dbcon.php';

//Input field validation
function validate($inputData){

  global $conn;
  $validatedDate = mysqli_real_escape_string($conn, $inputData);
  return trim($validatedDate);
}


//Redirect from 1 page to another page with the message (status)
function Redirect($url,$status){
  $_SESSION['status'] = $status;
  header('Location: '. $url);
  exit(0);
}

//Display message or status after any process 
function alertMEssage(){

  if(isset($_SESSION['status'])){

    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>  <h6> '.$_SESSION['status'].' </h6>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';

    unset($_SESSION['status']);
  }
}

//Insert record using this function
function insert($tableName,$data){
  global $conn;

  $table = validate($tableName);
  $columns = array_keys($data);
  $values = array_values($data);

  $finalColumns = implode(',',$columns);
  $finalValues = "'".implode("','",$values)."'";

  $query = "INSERT INTO $table ($finalColumns) VALUES ($finalValues)";
  $result = mysqli_query($conn,$query);
  return $result;
}

//Update data using this function
function update($tableName,$id,$data){
  global $conn;

  $table = validate($tableName);
  $id = validate($id);

  $updateDataString = "";

  foreach($data as $column => $value){
    $updateDataString .= $column.'='."'$value',";
  }  

  $finalUpdateData = substr(trim($updateDataString),0,-1);

  $query ="UPDATE $table SET $finalUpdateData WHERE id='$id'";
  $result = mysqli_query($conn,$query);
  return $result;
}

function getAll($tableName, $status = NULL){

  global $conn;

  $table = validate($tableName);
  $status = validate($status);

  if($status == 'status'){

    $query = "SELECT * FROM $table WHERE status='0'";
  }
  else{
    $query = "SELECT * FROM $table";
  }
  return mysqli_query( $conn,$query);
}

function getById($tableName,$id){
  global $conn;

  $table = validate($tableName);
  $id = validate($id);

  $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
  $result = mysqli_query($conn,$query);
  
  if($result){
    if(mysqli_num_rows($result)==1 ){

      $row = mysqli_fetch_assoc($result);
      $response = [
        'status' => 200,
        'data' => $row,
        'message' => 'record found'
      ];
      return $response;

    }else{
      $response = [
        'status' => 404,
        'message' => 'No Data Found'
      ];
      return $response;
    }

  }
  else{
    $response = [
      'status' => 500,
      'message' => 'something went wrong'
    ];
    return $response;
  }
}

//Delete data from database using id
function delete($tableName,$id){
  global $conn;

  $table = validate($tableName);
  $id = validate($id);

  $query = "DELETE FROM $table WHERE id ='$id' LIMIT 1";
  $result = mysqli_query($conn,$query);
  return $result;
}

function checkParamId($type){
  if(isset($_GET[$type])){
    if($_GET[$type] != ''){
      return $_GET[$type];
    }
    else{
      return '<h5>No Id Found</h5>';
    }
  }
  else{
    return '<h5>No Id Given</h5>';
  }
}

function logoutSeesion(){

  unset($_SESSION['loggedIn']);
  unset($_SESSION['loggedInUser']);
}

function jsonResponse($status,$status_type,$message){
  $response = [
    'status' => $status,
    'status_type' => $status_type,
    'message' => $message
  ];
  echo json_encode($response);
  return;
}

?>