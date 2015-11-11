<?php

require_once('../sys/sys_db_connect.php');
require_once('../sys/sys_functions.php');

wcp_session_start();


 if (isLoggedIn($mysqli) != true) { 
 	echo '<span>У вас нет прав для просмотра этой страницы! </span><a href="../login">Войти</a>.';
    echo '</p>';
    die(); 
}

// Application inititalizer: 
 require_once('module/app/application.php');  // App
 require_once('module/app/user.php'); 		  // User
 $user = new User($_SESSION['userID'], 'user', $_SESSION['permissions']);
 SysApplication::setSession($user->getPermissions()); // Preparing for protection. 

 //  Manager init:
 require_once('module/app/wcc_manager.php');  
	 $waycup = new WCCManager($mysqli, $user);
 // /Manager init

//  post Handler
if (count($_POST) <> 0) {
	$waycup->postHandler($_POST);
}
// /post Handler

//  Page init
 require_once('module/app/sys_module-manager.php'); 
 SysApplication::setPages($navBarPages, $adminPages, $orderPages, $otherPages); 
// /Page init

 $pageID = (isset($_GET['page'])) ? $_GET['page'] : 0;  
 $page   = SysApplication::getPageByIndex($pageID); 
 
 SysApplication::prepareToShow($page); 

 switch ($page->getType()) {
 	case 'navigation':
		 SysApplication::get('Header'); 

		 SysApplication::get('NavBar');

		 SysApplication::showCurrentPage(); 

		 SysApplication::get('Footer'); 
 		break;

 	case 'order':
 	     SysApplication::get('Header');  

 	     echo "<div class='span12'>";
 	     echo "<div class='main-content'>";

		 SysApplication::showCurrentPage(); 

		 SysApplication::get('Footer'); 
 		break;
 	
 	default:
 		SysApplication::show404();
 		break;
 }

