<?php

class ControllerArticle extends Controller 
{
	public function init()
	{
		
	}

	public function index()
	{
		$offset = (empty($this->args["offset"])) ? 0 : $this->args["offset"];



		$data = Recherche::recherche_by_text("%%", $offset);


		return $this->app
					->view
					->render($this->response, 'front/listerecherche.html', $data);
	}
}