<?php

abstract class Controller 
{
	protected $app;
	protected $request;
	protected $response;
	protected $args;
	protected $section;

	function __construct($app, $request, $response, $args)
	{
		$this->app 		= $app;
		$this->request 	= $request;
		$this->response = $response;
		$this->args 	= $args;
		$this->setSection("");
		$this->init();
	}

	abstract function init();

	function setSection($value)
	{
		$this->section = $value;
		$this->app->view->offsetSet('section', $this->section);
	}
}