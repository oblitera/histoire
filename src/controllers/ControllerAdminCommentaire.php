<?php

class ControllerAdminCommentaire extends ControllerAdmin 
{
	static $MSG_SECTION				= "commentaire";
	static $MSG_UPDATE_VALIDE 		= "Commentaire édité avec succés";
	static $MSG_CREATE_VALIDE 		= "Commentaire ajouter avec succés";
	static $MSG_DELETE_VALIDE 		= "Commentaire supprimer avec succés";
	static $ERROR_INCONNU 			= "Commentaire inconnu, opération annulée";

	public function init()
	{
		parent::init();
		$this->setSection(self::$MSG_SECTION);
	}

	public function index()
	{
		$data = array(
			"commentaires" => Commentaire::with('article','auteur')->get()
		);

		return $this->app->view->render($this->response, 'admin/commentaire/commentaire_index.html', $data);
	}

	public function show()
	{
		//initialisation
		$cible = Commentaire::with('auteur', 'article')->find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$data = array(
			"commentaire" => $cible->toArray()
		);

		return $this->app->view->render($this->response, 'admin/commentaire/commentaire_show.html', $data);
	}

	public function create()
	{
		//initialisation
		$article = Article::find($this->args["article"]);
		if(empty($article))
		{
			return $this->redirect_inconnu();
		}

		$data = array(
			"auteurs" => Auteur::all()->toArray(),
			"article" => $article->toArray()
		);

		return $this->app
					->view
					->render($this->response, 'admin/commentaire/commentaire_add.html', $data);
	}

	public function store()
	{
		//initialisation
		$article = Article::find($this->args["article"]);
		if(empty($article))
		{
			return $this->redirect_inconnu();
		}

		$validation = CommentaireValidation::validate_post($_POST, true, false);
		if($validation === true)
		{
			Commentaire::add($article, $_POST);

			$this->app
				 ->flash
				 ->addMessage('success', ControllerAdminCommentaire::$MSG_CREATE_VALIDE);

			$route = $this->app
						  ->router
						  ->pathFor('admin.article.show',['id' => $article->id]);

	    	return $this->response
	    				->withStatus(301)
	    				->withHeader('Location', $route);
		}

		$data = array(
			"auteurs" => Auteur::all()->toArray(),
			"article" => $article->toArray(),
			"values"  => $validation["values"],
			"errors"  => $validation["errors"]
		);


		return $this->app
					->view
					->render($this->response, 'admin/commentaire/commentaire_add.html', $data);
	}

	public function edit()
	{
		//initialisation
		$cible = Commentaire::with('auteur', 'article')->find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$data = array(
			"values" => $cible->toArray()
		);

		return $this->app->view->render($this->response, 'admin/commentaire/commentaire_edit.html', $data);
	}

	public function update()
	{
		//initialisation
		$cible = Commentaire::with('auteur', 'article')->find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$validation = CommentaireValidation::validate_post($_POST, false, true);
		if($validation === true)
		{
			$cible->contenu = $_POST["contenu"];
			$cible->actif 	= $_POST["actif"];
			$cible->save();

			$this->app->flash->addMessage('success', ControllerAdminCommentaire::$MSG_UPDATE_VALIDE);

			if(empty($_GET["redirect"]))
			{
				$route = $this->app
							  ->router
							  ->pathFor('admin.article.show',["id" => $cible['article']['id']]);
			}
			else
			{
				$route = $this->app
							  ->router
							  ->pathFor('admin.commentaire.index',[]);				
			}

	    	return $this->response
	    				->withStatus(301)
	    				->withHeader('Location', $route);
		}	

		return $this->app->view->render($this->response, 'admin/commentaire/commentaire_edit.html', $validation);
	}

	public function destroy()
	{
		//initialisation
		$cible = Commentaire::with('auteur', 'article')->find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$cible->delete();

		$this->app->flash->addMessage('success', ControllerAdminCommentaire::$MSG_DELETE_VALIDE);

		if(empty($_GET["redirect"]))
		{
			$route = $this->app
						  ->router
						  ->pathFor('admin.article.show',["id" => $cible['article']['id']]);
		}
		else
		{
			$route = $this->app
						  ->router
						  ->pathFor('admin.commentaire.index',[]);				
		}

    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);	
	}

}