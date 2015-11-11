<?php 

class SysApplication {

// properties:

static protected $navBarPages;
static protected $adminPages;
static protected $orderPages;
static protected $otherPages;
static protected $currentPage;
static protected $currentShop; // Meaning the shop that uses this interface.


// Hz if needed:
// This basicly contains all the arrays above, but merged.

static protected $unorderedPages;

// It is needed, but I think it could be simplified

static public $currentSession = false;

// methods:

	public static function get($element){
		$func = 'get' . $element;
		if (method_exists(get_class(), $func)) {
			forward_static_call(get_class() . '::' . $func);
		} else {
			throw new \Exception('Function ' . $func . '() does not exist.');
		}
	}

	// Layout elements:

	public static function getHeader() {
		include_once('module/app/header.php');
	}

	public static function getFooter() {
		include_once('module/app/footer.php');
	}

	public static function getNavBar() {
		include_once('module/app/navbar.php');	
	}

	// Initializers:

	public static function setSession($permissions) {
		SysApplication::$currentSession = $permissions;
	}

	// Page arrays:

	public static function getAllPages() {
		return SysApplication::$unorderedPages;
	}

	public static function getNavBarPages() {
		return SysApplication::$navBarPages;
	}

	public static function getAdminPages() {
		return SysApplication::$adminPages;
	}

	public static function getOrderPages() {
		return SysApplication::$orderPages;
	}

	public static function getOtherPages() {
		return SysApplication::$otherPages;
	}


	public static function setPages($navBarPages, $adminPages, $orderPages, $otherPages) {
		SysApplication::$navBarPages 	= $navBarPages;
		SysApplication::$adminPages  	= $adminPages;
		SysApplication::$orderPages  	= $orderPages;
		SysApplication::$otherPages  	= $otherPages;
		SysApplication::$unorderedPages = array_merge($navBarPages, $adminPages, $orderPages, $otherPages);
	}

	// Page geters:

	public static function getPageByName($name) {
		foreach (SysApplication::$unorderedPages as $index => $page) {
			if ($page->name == $name) {
				return $page;
			}
		}
		$page = new SysPage();
		$page->turn404();
		return $page;
	}

	public static function getPageIndexByName($name) {
		foreach (SysApplication::$unorderedPages as $index => $page) {
			if ($page->name == $name) {
				return $index;
			}
		}
		return 0;
	}


	public static function getPageByIndex($index) {
		$index = intval($index);
		if ($index < count(SysApplication::$unorderedPages)) {
			return SysApplication::$unorderedPages[$index];
		} else {
			$page = new SysPage();
			$page->turn404();
			return $page;
		}
	}


	public static function getCurrentPage() {
		if (SysApplication::$currentPage != null) {
			return SysApplication::$currentPage;
		} else {
			$page = new SysPage();
			$page->turn404();
			return $page;
		}
	}

	// App methods:

	public static function prepareToShow($page) {
		if ((gettype($page) != gettype(new SysPage())) or (!file_exists($page->getHref()))) {
			$page = new SysPage();
			$page->turn404();
		} 

		SysApplication::$currentPage = $page;
	}

	public static function showCurrentPage() {
		SysApplication::$currentPage->show();
	}


	public static function setShop($shop) {
		SysApplication::$currentShop = $shop;
	}

	public static function show404() {
		$page = new SysPage();
		$page->turn404();
		SysApplication::$currentPage = $page;

		SysApplication::showCurrentPage();
	}

	public static function callManager($module, $directCall = null) {
		$path = 'module/' . $module . '/' . $module . '_manager.php';
		
		if (file_exists($path)) {
			include_once($path);
			if (isset($manager)) {
				return $manager;	
			} else {
				if ($directCall != null) {
					global $mysqli;
					$manager = new $directCall($mysqli);
					return $manager;
				} else {
					die("<h2>Conflict occured!</h2> Couldnt call $module manager!");
				}
			}
			
		} else { 
			echo "Warning! Manager '$module' hasn't been found!";
		}
	}

}
