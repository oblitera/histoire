<?php

class Controller 
{
	protected $app;
	protected $request;
	protected $response;
	protected $args;

	function __construct($app, $request, $response, $args)
	{
		$this->app 		= $app;
		$this->request 	= $request;
		$this->response = $response;
		$this->args 	= $args;
	}
}