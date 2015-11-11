<?php

	class SysPageFactory {

		public static function addPage($pageType, $href, $classname = '', $name = '') {
			$page = 'SysPage' . ucfirst($pageType);

			if (class_exists($page)) {
				return new $page($href, $classname, $name);
			} else {
				throw new \Exception('Хуйня случилась, сорян.');
			}
		}
	}




	class SysPage {
		protected $href   = 'example.php';
		protected $class  = 'icon-example';
		protected $type   =  null;

		public 	  $name   = 'Пример';
		public 	  $id 	  = 'example';
		public 	  $status = 'open';
		

		function __construct($href = '', $class = '', $name = '') {
			// I have no idea why did I use '../' at the first place. 
			// So I've decided to keep it here.

			// $this->href  = '../' . $href;
			// $this->href  = $href;
			
			$this->id    = $href;
			$this->href  = 'module/' . $href  . '/index.php';
			$this->class = $class;
			$this->name  = $name;
			
		} 

		function block() {
			$this->href   = 'module/app/norights.php';
			$this->name   = 'No rights found';
			$this->status = 'blocked';
		}

		function turn404() {
			$this->href   = 'module/app/404.php';
			$this->name   = 'No page found';
			$this->status = '404ed';
		}

		function show() {
			include($this->getHref());
		}

		function getType() {
			return $this->type;
		}

		function getHref() {
			return $this->href;
		}

		function getClass() {
			return $this->class;
		}

		public function markActive() {
		    if ($this->name == SysApplication::getCurrentPage()->name) {
		      return 'id = "active"';
		    } else {
		      return '';
		    }
	  	}

	}

	class SysPageNavigation extends SysPage {
		protected $type = 'navigation';
	}

	class SysPageAdmin extends SysPage {
		protected $type = 'admin';
	}

	class SysPageOrder extends SysPage {
		protected $type = 'order';
	}

	class SysPageOther extends SysPage {
		protected $type = 'other';
	}
