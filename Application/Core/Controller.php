<?php
class Core_Controller
{
	public $view;
	public $model;
	public $error;
	
	public function getPost($object)
	{
		//gets data from $_POST array and makes them properties of argument class
		foreach($_POST as $key=>$value){
			$object->$key = isset($key) ? trim($value) : null;
		}
		return $object;
	}
}