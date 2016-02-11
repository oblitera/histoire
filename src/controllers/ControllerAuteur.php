<?php

class ControllerAuteur extends Controller 
{
	public function index()
	{
		return $this->app->view->render($this->response, 'auteur_index.html');
	}

	public function create()
	{
		//Controlle auteur
		/*$auteur = ControllerAuteur::session_auteur();
		if(empty($auteur))
		{
			return $this->redirect_unauthorized();
		}*/

		return $this->app->view->render($this->response, 'auteur_add.html');
	}


	/*

	public function store()
	{
		$validation = Auteur::validate($_POST);

	    if($validation === true)
	    {
	    	if(Auteur::isUniqueEmail($_POST['email']))
	    	{
	    		Auteur::add($_POST);
	    		$route = $this->app->router->pathFor('auteur.index',[]);
	        	return $this->response->withStatus(301)->withHeader('Location', $route);	    		
	    	}
	    	else
	    	{
				$validation = array(
					'errors' => array('email' => ["Cet email est déjà utilisé"]),
					'values' => $_POST
				);
	    	}
	    }

	    return $this->app->view->render($this->response, 'auteur_add.html', $validation);
	}


	public function edit()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);
		
		if(empty($cible))
		{
			$route = $this->app
						->router
						->pathFor('auteur.index',[]);
			
			return $this->response
						->withStatus(301)
						->withHeader('Location', $route);
		}
		
		$data = array(
			'values' => $cible->toArray()
		);
		
		return $this->app
					->view
					->render($this->response, 'auteur_edit.html', $data);		
	}
	
	public function update()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);

		if(empty($cible))
		{
			$route = $this->app
						  ->router
						  ->pathFor('auteur.index',[]);

			return $this->response
						->withStatus(301)
						->withHeader('Location', $route);
		}

		//go validation !
		$validation = Auteur::validate($_POST, false);
	    if($validation === true)
	    {
	    	if(Auteur::isValidUpdateEmail($cible->email, $_POST["email"]))
	    	{
	    		Auteur::edit($cible, $_POST);

	    		$route = $this->app
	    					  ->router
	    					  ->pathFor('auteur.index',[]);

	        	return $this->response
	        				->withStatus(301)
	        				->withHeader('Location', $route);		    		
	    	}
	    	else
	    	{
				$validation = array(
					'errors' => array('email' => ["Cet email est déjà utilisé"]),
					'values' => $_POST
				);	    		
	    	}
	    }

	    return $this->app
	    			->view
	    			->render($this->response, 'auteur_edit.html', $validation);
	}
	
	public function destroy()
	{

	}*/

	static function session_auteur()
	{
		if(empty($_SESSION['contributeur']))
		{
			return false;
		}
		
		if(!is_numeric($_SESSION['contributeur']))
		{
			return false;
		}

		$auteur = Auteur::find($_SESSION['contributeur']);

		if(empty($auteur))
		{
			return false;
		}	

		return $auteur;	
	}

	protected function redirect_unauthorized()
	{
	    $route = $this->app->router->pathFor('auteur.index',[]);
	    $this->app->flash->addMessage('error', 'vous devez être contributeur');
	    return $this->response->withStatus(301)->withHeader('Location', $route);
	}

	static function controler_article_utilisateur($idArticle, $contributeur)
	{

	}
	
}