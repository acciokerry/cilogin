<?php

class Role{

	const ADMIN 	= 1;
	const GROUP 	= 2;
	const VENDOR 	= 3;
	const CUSTOMER 	= 4;

	static function getRoles($role){
		return [
			'admin' 	=> self::ADMIN == $role,
			'group'		=> self::GROUP == $role,
			'vendor' 	=> self::VENDOR == $role,
			'customer'	=>	self::CUSTOMER == $role 
		];
	}
}