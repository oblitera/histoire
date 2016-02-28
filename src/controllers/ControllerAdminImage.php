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
		$data = array(
			"images" => Image::with('article')->get()
		);

		return $this->app
					->view
					->render($this->response, 'admin/image/image_index.html', $data);
	}

	public function indexarticle()
	{
		//initialisation
		$article = Article::with('images')->find($this->args["article"]);
		if(empty($article))
		{
			return $this->redirect_inconnu();
		}

		$data = array(
			"article" => $article->toArray()
		);

		return $this->app
					->view
					->render($this->response, 'admin/image/image_indexarticle.html', $data);
	}

	public function store()
	{
		//initialisation
		$article = Article::find($this->args["article"]);
		if(empty($article))
		{
			return $this->redirect_inconnu();
		}

		$legende = "" ;
		if(ImageValidation::validate_legende($_POST) === true)
		{
			$legende = $_POST["legende"];
		}

		$validation = ImageValidation::validate_post_img($_FILES);
	    if($validation === true)
	    {
	    	Image::add($_FILES, $legende, $article);

			$this->app
				 ->flash
				 ->addMessage('success', self::$MSG_CREATE_VALIDE);

			$route = $this->app
						  ->router
						  ->pathFor('admin.image.indexarticle',["article" => $article->id]);

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
		$image = Image::find($this->args["id"]);
		if(empty($image))
		{
			return $this->redirect_inconnu();
		}

		$data = array(
			"article"	=> $article,
			"values"	=> $image->toArray()
		);

		return $this->app->view->render($this->response, 'admin/image/image_edit.html', $data);
	}

	public function update()
	{
		$image = Image::with('article')->find($this->args["id"]);
		if(empty($image))
		{
			return $this->redirect_inconnu();
		}

		$validation = ImageValidation::validate_post_img($_FILES);
	    if($validation === true)
	    {
	    	Image::edit_file($image, $_FILES);
	    }

	    $legende = "";	   
		if(ImageValidation::validate_legende($_POST) === true)
		{
			$legende = $_POST["legende"];
		}

	    $actif = "0";	   
		if(ImageValidation::validate_actif($_POST) === true)
		{
			$actif = $_POST["actif"];
		}

		$image->legende = $legende;
		$image->actif = $actif;
		$image->save();

		$this->app->flash->addMessage('success', self::$MSG_UPDATE_VALIDE);

		if(empty($_GET["redirect"]))
		{
			$route = $this->app
						  ->router
						  ->pathFor('admin.image.indexarticle',["article" => $image["article"]["id"]]);	
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