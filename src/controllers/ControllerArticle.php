<?php

class ControllerArticle extends Controller 
{
	public function init()
	{
		
	}

	public function index()
	{
		$data = array(
			"data" => Recherche::recherche_by_text("%%")->toArray()
		);

		/*echo("<pre>");
		var_dump($data);die();*/

		return $this->app
					->view
					->render($this->response, 'front/listerecherche.html', $data);
	}
}