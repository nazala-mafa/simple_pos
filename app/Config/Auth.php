<?php namespace Config;

use Myth\Auth\Config\Auth as BaseAuth;

class Auth extends BaseAuth
{
	public $views = [
		'login'		   => 'auth/login',
		'register'		=> 'auth/register',
		'forgot'		  => 'Myth\Auth\Views\forgot',
		'reset'		   => 'Myth\Auth\Views\reset',
		'emailForgot'	 => 'Myth\Auth\Views\emails\forgot',
		'emailActivation' => 'Myth\Auth\Views\emails\activation',
	];
	
	public $allowRegistration = false;
	public $allowRemembering = true;
}
