<?php 
include_once('../sys/sys_db_connect.php');
include_once('../sys/sys_functions.php');
wcp_session_start();

  if (isLoggedIn($mysqli)){
    header("Location: ../erp");
  } else {
    include_once("login.php");
  }
               
 