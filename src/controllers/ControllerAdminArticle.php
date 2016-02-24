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
		$this->setSection(ControllerAdminArticle::$MSG_SECTION);
	}

	public function index()
	{
		$data = array(
			"articles" => Article::all()->toArray()
		);

		return $this->app->view->render($this->response, 'admin/article/article_index.html', $data);
	}

	public function show()
	{
		return $this->app->view->render($this->response, 'admin/article/article_show.html');
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

		$validation = Article::validate($_POST);
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

		$validation = Article::validate($_POST);
		if($validation === true)
		{
			$cible::edit($cible, $_POST);

			$images = $this->getPostImg();
			if($images)
			{

			}

			$this->app->flash->addMessage('success', ControllerAdminArticle::$MSG_UPDATE_VALIDE);

			$route = $this->app
						  ->router
						  ->pathFor('admin.article.index',[]);

	    	return $this->response
	    				->withStatus(301)
	    				->withHeader('Location', $route);			
		}		

		$data = array(
			'values' => $cible->toArray(),
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