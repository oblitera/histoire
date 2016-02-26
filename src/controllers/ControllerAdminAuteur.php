<?php

class ControllerAdminAuteur extends ControllerAdmin 
{
	static $MSG_SECTION				= "auteur";
	static $MSG_UPDATE_VALIDE 		= "Auteur éditer avec succés";
	static $MSG_UPDATE_MDP_VALIDE 	= "Le mot de passe de l'auteur a été édité avec succés";
	static $MSG_CREATE_VALIDE 		= "Auteur ajouter avec succés";
	static $MSG_DELETE_VALIDE 		= "Auteur supprimer avec succés";
	static $ERROR_INCONNU 			= "Auteur inconnu, opération annulée";


	public function init()
	{
		parent::init();
		$this->setSection(ControllerAdminAuteur::$MSG_SECTION);
	}


	/*------------------
	 *  Affichage
	 *------------------
	 */


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
			return $this->redirect_inconnu();
		}

		$data = array(
			'auteur' => $cible->toArray()
		);

		return $this->app->view->render($this->response, 'admin/auteur/auteur_show.html', $data);
	}


	/*------------------
	 *  Creation
	 *------------------
	 */


	public function create()
	{
		return $this->app->view->render($this->response, 'admin/auteur/auteur_add.html');
	}
	

	public function store()
	{
		//on tente l'édition !
		$validation = AuteurValidation::validate_created($_POST);
	    if($validation === true)
	    {
		    Auteur::add($_POST);

			$this->app
				 ->flash
				 ->addMessage('success', ControllerAdminAuteur::$MSG_CREATE_VALIDE);

			$route = $this->app
						  ->router
						  ->pathFor('admin.auteur.index',[]);

	    	return $this->response
	    				->withStatus(301)
	    				->withHeader('Location', $route);
	    }	

	    return $this->app->view->render($this->response, 'admin/auteur/auteur_add.html', $validation);
	}


	/*------------------
	 *  Edition
	 *------------------
	 */

	public function edit()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
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
			return $this->redirect_inconnu();
		}

		//on tente l'édition !
		$validation = AuteurValidation::validate_update($_POST, $cible->email, $cible->pseudo);
		if($validation === true)
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

		//si c'est pas ok : /
		return $this->app
	    			->view
	    			->render($this->response, 'admin/auteur/auteur_edit.html', $validation);
	}
	

	/*------------------
	 *  Changer mot de passe
	 *------------------
	 */

	public function editmdp()
	{
		return $this->app->view->render($this->response, 'admin/auteur/auteur_editmdp.html');
	}
	
	public function updatemdp()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$validation = AuteurValidation::isValidePass($_POST);
		if($validation === true)
		{
			$cible->mdp = md5($data["mdp"]);
			$cible->save();

			$this->app->flash->addMessage('success', ControllerAdminAuteur::$MSG_UPDATE_MDP_VALIDE);

			$route = $this->app
						  ->router
						  ->pathFor('admin.auteur.index',[]);

	    	return $this->response
	    				->withStatus(301)
	    				->withHeader('Location', $route);	
		}

	    return $this->app
	    			->view
	    			->render($this->response, 'admin/auteur/auteur_editmdp.html', $validation);		
	}
	

	/*------------------
	 *  Suppresion
	 *------------------
	 */

	public function destroy()
	{
		//initialisation
		$cible = Auteur::find($this->args["id"]);
		if(empty($cible))
		{
			return $this->redirect_inconnu();
		}

		$cible->delete();

		$this->app->flash->addMessage('success', ControllerAdminAuteur::$MSG_DELETE_VALIDE);

		$route = $this->app
					  ->router
					  ->pathFor('admin.auteur.index',[]);

    	return $this->response
    				->withStatus(301)
    				->withHeader('Location', $route);	
	}


	protected function redirect_inconnu()
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