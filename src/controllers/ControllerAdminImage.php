<?php

class ControllerAdminImage extends ControllerAdmin 
{
	static $MSG_SECTION				= "image";
	static $MSG_UPDATE_VALIDE 		= "image édité avec succés";
	static $MSG_CREATE_VALIDE 		= "image ajouter avec succés";
	static $MSG_DELETE_VALIDE 		= "image supprimer avec succés";
	static $ERROR_INCONNU 			= "image inconnu, opération annulée";

	public function init()
	{
		parent::init();
		$this->setSection(self::$MSG_SECTION);
	}

	public function index()
	{
		return $this->app
					->view
					->render($this->response, 'admin/image/image_index.html');
	}

	public function indexarticle()
	{
		//initialisation
		$article = Article::find($this->args["article"]);
		if(empty($article))
		{
			return $this->redirect_inconnu();
		}

		return $this->app
					->view
					->render($this->response, 'admin/image/image_indexarticle.html');
	}

	public function show()
	{
		return $this->app
					->view
					->render($this->response, 'admin/image/image_show.html');
	}

	public function create()
	{
		return $this->app
					->view
					->render($this->response, 'admin/image/image_add.html');
	}

	public function store()
	{
		//initialisation
		$article = Article::find($this->args["article"]);
		if(empty($article))
		{
			return $this->redirect_inconnu();
		}

		$validation = ImageValidation::validate_created($_FILES);
	    if($validation === true)
	    {
			$this->app
				 ->flash
				 ->addMessage('success', self::$MSG_CREATE_VALIDE);

			$route = $this->app
						  ->router
						  ->pathFor('admin.image.indexarticle',["article" => 1]);

	    	return $this->response
	    				->withStatus(301)
	    				->withHeader('Location', $route);
	    }

		return $this->app
					->view
					->render($this->response, 'admin/image/image_indexarticle.html', $validation);
	}

	public function edit()
	{
		return $this->app->view->render($this->response, 'admin/image/image_edit.html');
	}

	public function update()
	{
		$this->app->flash->addMessage('success', self::$MSG_UPDATE_VALIDE);

		if(empty($_GET["redirect"]))
		{
			$route = $this->app
						  ->router
						  ->pathFor('admin.image.indexarticle',["article" => 1]);	
		}
		else
		{
			$route = $this->app
						  ->router
						  ->pathFor('admin.image.index',[]);					
		}


    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);	

		return $this->app->view->render($this->response, 'admin/image/image_show.html');
	}

	public function destroy()
	{
		if(empty($_GET["redirect"]))
		{
			$route = $this->app
						  ->router
						  ->pathFor('admin.image.indexarticle',["article" => 1]);	
		}
		else
		{
			$route = $this->app
						  ->router
						  ->pathFor('admin.image.index',[]);					
		}

		$this->app->flash->addMessage('success', self::$MSG_DELETE_VALIDE);

		$route = $this->app
					  ->router
					  ->pathFor('admin.image.index',[]);

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