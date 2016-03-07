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

	public function show()
	{
		//initialisation
		$cible = Article::with("auteur","images","commentaires")->find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$data = $cible->toArray();
		$data["resultat_proches"] = Recherche::recherche_by_proximity($data["coordonnee_long"],$data["coordonnee_lat"]);
		
		/*echo("<pre>");
		var_dump($data["resultat_proches"]);
		die();*/

		return $this->app->view->render($this->response, 'front/article_view.html', $data);
	}

	protected function redirect_inconnu()
	{
		$route = $this->app
					  ->router
					  ->pathFor('front.article.index',[]);


		return $this->response
					->withStatus(301)
					->withHeader('Location', $route);
	}
}