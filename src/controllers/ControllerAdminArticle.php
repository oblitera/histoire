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
		return $this->app->view->render($this->response, 'admin/article/article_index.html');
	}

	public function show()
	{
		return $this->app->view->render($this->response, 'admin/article/article_show.html');
	}

	public function create()
	{
		return $this->app->view->render($this->response, 'admin/article/article_add.html');
	}

	public function store()
	{
		$this->app->flash->addMessage('success', ControllerAdminArticle::$MSG_CREATE_VALIDE);
		$route = $this->app->router->pathFor('admin.article.index',[]);
    	return $this->response->withStatus(301)->withHeader('Location', $route);
	}

	public function update()
	{
		$this->app->flash->addMessage('success', ControllerAdminArticle::$MSG_UPDATE_VALIDE);

		$route = $this->app
					  ->router
					  ->pathFor('admin.article.index',[]);

    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);	

		return $this->app->view->render($this->response, 'admin/article/article_show.html');
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

}