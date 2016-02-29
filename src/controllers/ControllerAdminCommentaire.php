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
		$this->setSection(ControllerAdminCommentaire::$MSG_SECTION);
	}

	public function index()
	{
		return $this->app->view->render($this->response, 'admin/commentaire/commentaire_index.html');
	}

	public function show()
	{
		return $this->app->view->render($this->response, 'admin/commentaire/commentaire_show.html');
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

		$validation = CommentaireValidation::validate_post($_POST);
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
		return $this->app->view->render($this->response, 'admin/commentaire/commentaire_edit.html');
	}

	public function update()
	{
		$this->app->flash->addMessage('success', ControllerAdminCommentaire::$MSG_UPDATE_VALIDE);

		$route = $this->app
					  ->router
					  ->pathFor('admin.commentaire.index',[]);

    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);	

		return $this->app->view->render($this->response, 'admin/commentaire/commentaire_show.html');
	}

	public function destroy()
	{
		$this->app->flash->addMessage('success', ControllerAdminCommentaire::$MSG_DELETE_VALIDE);

		$route = $this->app
					  ->router
					  ->pathFor('admin.commentaire.index',[]);

    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);	
	}

}