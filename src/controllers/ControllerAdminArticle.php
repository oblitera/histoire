<?php

class ControllerAdminArticle extends ControllerAdmin 
{
	static $MSG_SECTION				= "article";
	static $MSG_UPDATE_VALIDE 		= "Article édité avec succés";
	static $MSG_CREATE_VALIDE 		= "Article ajouter avec succés";
	static $MSG_DELETE_VALIDE 		= "Article supprimer avec succés";
	static $ERROR_INCONNU 			= "Article inconnu, opération annulée";

	public function init()
	{
		parent::init();
		$this->setSection(self::$MSG_SECTION);
	}

	public function index()
	{
		$data = array(
			"articles" => Article::with("auteur")->get()->toArray()
		);

		return $this->app->view->render($this->response, 'admin/article/article_index.html', $data);
	}

	public function show()
	{
		//initialisation
		$cible = Article::with('auteur','images', 'commentaires')->find($this->args["id"]);

		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$data = array(
			"article" => $cible->toArray()
		);

		return $this->app->view->render($this->response, 'admin/article/article_show.html', $data);
	}

	public function create()
	{
		$data = array(
			"auteurs" => Auteur::all()->toArray()
		);

		return $this->app->view->render($this->response, 'admin/article/article_add.html', $data);
	}

	public function store()
	{
		$data = array(
			"auteurs" => Auteur::all()->toArray()
		);

		$validation = ArticleValidation::validate_created($_POST);
		if($validation === true)
		{
			Article::add($_POST);
			$this->app->flash->addMessage('success', ControllerAdminArticle::$MSG_CREATE_VALIDE);
			$route = $this->app->router->pathFor('admin.article.index',[]);
	    	return $this->response->withStatus(301)->withHeader('Location', $route);			
		}

		$data = array_merge($data, $validation);
		return $this->app->view->render($this->response, 'admin/article/article_add.html', $data);
	}

	public function edit()
	{
		//initialisation
		$cible = Article::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$data = array(
			'values' => $cible->toArray(),
			'auteurs' => Auteur::all()->toArray()
		);

		return $this->app->view->render($this->response, 'admin/article/article_edit.html', $data);
	}

	public function update()
	{
		//initialisation
		$cible = Article::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$validation = ArticleValidation::validate_created($_POST, true);
		if($validation === true)
		{
			$cible::edit($cible, $_POST);

			$this->app->flash->addMessage('success', ControllerAdminArticle::$MSG_UPDATE_VALIDE);

			$route = $this->app
						  ->router
						  ->pathFor('admin.article.index',[]);

	    	return $this->response
	    				->withStatus(301)
	    				->withHeader('Location', $route);			
		}		

		$data = array(
			'values' => $_POST,
			'auteurs' => Auteur::all()->toArray()
		);
		$data = array_merge($data, $validation);

		return $this->app->view->render($this->response, 'admin/article/article_edit.html', $data);
	}

	public function destroy()
	{
		$this->app->flash->addMessage('success', ControllerAdminArticle::$MSG_DELETE_VALIDE);

		$route = $this->app
					  ->router
					  ->pathFor('admin.article.index',[]);

    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);	
	}

	protected function redirect_inconnu()
	{
		$route = $this->app
					  ->router
					  ->pathFor('admin.article.index',[]);

		$this->app
			 ->flash
			 ->addMessage('error', self::$ERROR_INCONNU);

		return $this->response
					->withStatus(301)
					->withHeader('Location', $route);
	}
}