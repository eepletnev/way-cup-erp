<?php 

class User {
	public $id;
	public $name;
	protected $permissions;

	public function getPermissions() {
		return $this->permissions;
	}

	function __construct($id, $name, $permissions) {
		$this->id = $id;
		$this->name = $name;
		$this->permissions = $permissions;
	}
}