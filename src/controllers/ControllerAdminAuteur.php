<?php

class ControllerAdminAuteur extends ControllerAdmin 
{
	static $MSG_SECTION				= "auteur";
	static $MSG_UPDATE_VALIDE 		= "Auteur éditer avec succés";
	static $MSG_UPDATE_MDP_VALIDE 	= "Le mot de passe de l'auteur a été édité avec succés";
	static $MSG_CREATE_VALIDE 		= "Auteur ajouter avec succés";
	static $MSG_DELETE_VALIDE 		= "Auteur supprimer avec succés";
	static $ERROR_INCONNU 			= "Auteur inconnu, opération annulée";
	static $ERROR_PSEUDO_DUPLI		= "Ce pseudo est déjà utilisé";
	static $ERROR_EMAIL_DUPLI		= "Cet email est déjà utilisé";

	public function init()
	{
		parent::init();
		$this->setSection(ControllerAdminAuteur::$MSG_SECTION);
	}

	public function index()
	{
		$data = array(
			"auteurs" => Auteur::all()->toArray()
		);
		
		return $this->app->view->render($this->response, 'admin/auteur/auteur_index.html', $data);
	}

	public function show()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_article_iconnu();
		}

		$data = array(
			'auteur' => $cible->toArray()
		);

		return $this->app->view->render($this->response, 'admin/auteur/auteur_show.html', $data);
	}

	public function create()
	{
		return $this->app->view->render($this->response, 'admin/auteur/auteur_add.html');
	}
	

	public function store()
	{
		$validation = Auteur::validate($_POST);

	    if($validation === true)
	    {
	    	$uniqueEmail = Auteur::isUniqueEmail($_POST['email']);
	    	$uniquePseudo = Auteur::isUniquePseudo($_POST['pseudo']);
	    	
	    	if($uniqueEmail && $uniquePseudo)
	    	{
			    Auteur::add($_POST);
				$this->app->flash->addMessage('success', ControllerAdminAuteur::$MSG_CREATE_VALIDE);
				$route = $this->app->router->pathFor('admin.auteur.index',[]);
		    	return $this->response->withStatus(301)->withHeader('Location', $route);
	    	}
	    	elseif(!$uniqueEmail && !$uniquePseudo)
	    	{
				$validation = array(
					'errors' => array(
						'email'  => [self::$ERROR_PSEUDO_DUPLI],
						'pseudo' => [self::$ERROR_EMAIL_DUPLI]
					),
					'values' => $_POST
				);
	    	}
	    	elseif(!$uniqueEmail)
	    	{
				$validation = array(
					'errors' => array(
						'email' => [self::$ERROR_EMAIL_DUPLI]
					),
					'values' => $_POST
				);	    		
	    	}
	    	else
	    	{
				$validation = array(
					'errors' => array(
						'pseudo' => [self::$ERROR_PSEUDO_DUPLI]
					),
					'values' => $_POST
				);
	    	}
	    }	

	    return $this->app->view->render($this->response, 'admin/auteur/auteur_add.html', $validation);
	}


	public function edit()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_article_iconnu();
		}
		
		$data = array(
			'values' => $cible->toArray()
		);
		
		return $this->app
					->view
					->render($this->response, 'admin/auteur/auteur_edit.html', $data);		
	}
	
	public function update()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_article_iconnu();
		}

		//go validation !
		$validation = Auteur::validate($_POST, false);
	    if($validation === true)
	    {
	    	$uniqueEmail 	= Auteur::isValidUpdateEmail($cible->email, $_POST['email']);
	    	$uniquePseudo 	= Auteur::isValidUpdatePseudo($cible->pseudo, $_POST['pseudo']);

	    	if($uniqueEmail && $uniquePseudo)
	    	{
	    		Auteur::edit($cible, $_POST);

	    		$this->app->flash->addMessage('success', ControllerAdminAuteur::$MSG_UPDATE_VALIDE);

	    		$route = $this->app
	    					  ->router
	    					  ->pathFor('admin.auteur.index',[]);

	        	return $this->response
	        				->withStatus(301)
	        				->withHeader('Location', $route);		    		
	    	}
	    	elseif(!$uniqueEmail && !$uniquePseudo)
	    	{
				$validation = array(
					'errors' => array(
						'email'  => [self::$ERROR_PSEUDO_DUPLI],
						'pseudo' => [self::$ERROR_EMAIL_DUPLI]
					),
					'values' => $_POST
				);
	    	}
	    	elseif(!$uniqueEmail)
	    	{
				$validation = array(
					'errors' => array(
						'email' => [self::$ERROR_EMAIL_DUPLI]
					),
					'values' => $_POST
				);	    		
	    	}
	    	else
	    	{
				$validation = array(
					'errors' => array(
						'pseudo' => [self::$ERROR_PSEUDO_DUPLI]
					),
					'values' => $_POST
				);
	    	}
	    }

	    return $this->app
	    			->view
	    			->render($this->response, 'admin/auteur/auteur_edit.html', $validation);
	}
	
	public function destroy()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_article_iconnu();
		}

		$this->app->flash->addMessage('success', ControllerAdminAuteur::$MSG_DELETE_VALIDE);

		$route = $this->app
					  ->router
					  ->pathFor('admin.auteur.index',[]);

    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);	
	}

	public function editmdp()
	{
		return $this->app->view->render($this->response, 'admin/auteur/auteur_editmdp.html');
	}
	
	public function updatemdp()
	{
		$this->app->flash->addMessage('success', ControllerAdminAuteur::$MSG_UPDATE_MDP_VALIDE);

		$route = $this->app
					  ->router
					  ->pathFor('admin.auteur.index',[]);

    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);			
	}


	protected function redirect_article_iconnu()
	{
		$route = $this->app
					  ->router
					  ->pathFor('admin.auteur.index',[]);

		$this->app
			 ->flash
			 ->addMessage('error', self::$ERROR_INCONNU);

		return $this->response
					->withStatus(301)
					->withHeader('Location', $route);
	}
}